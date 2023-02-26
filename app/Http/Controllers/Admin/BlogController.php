<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CheckPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategoriesPivot;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        CheckPermission::checkAuth('Listar Blog');

        $posts = Blog::all();

        if ($request->ajax()) {
            $token = csrf_token();

            return Datatables::of($posts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($token) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="blog/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<form method="POST" action="blog/' . $row->id . '" class="btn btn-xs px-0"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' . $token . '"><button class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" onclick="return confirm(\'Confirma a exclusão desta postagem?\')"><i class="fa fa-lg fa-fw fa-trash"></i></button></form>';
                    return $btn;
                })
                ->addColumn('cover', function ($row) {
                    return '<div class="d-flex justify-content-center align-items-center"><img src=' . url('storage/blog/min/' . $row->cover) .  ' class="img-thumbnail d-block" width="360" height="207" alt="' . $row->title . '" title="' . $row->title . '"/></div>';
                })
                ->rawColumns(['action', 'cover'])
                ->make(true);
        }

        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckPermission::checkAuth('Criar Blog');
        $categories = BlogCategory::orderBy('title')->get();
        return view('admin.blog.create', \compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        CheckPermission::checkAuth('Criar Blog');

        $data = $request->all();
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)) . time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $data['cover'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/blog';
            $destinationPathMedium = storage_path() . '/app/public/blog/medium';
            $destinationPathMin = storage_path() . '/app/public/blog/min';
            $destinationPathContent = storage_path() . '/app/public/blog/content';

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 755, true);
            }

            if (!file_exists($destinationPathMedium)) {
                mkdir($destinationPathMedium, 755, true);
            }

            if (!file_exists($destinationPathMin)) {
                mkdir($destinationPathMin, 755, true);
            }

            if (!file_exists($destinationPathContent)) {
                mkdir($destinationPathContent, 755, true);
            }

            $img = Image::make($request->cover)->resize(null, 489, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(860, 489)->save($destinationPath . '/' . $nameFile);

            $imgMedium = Image::make($request->cover)->resize(null, 385, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(675, 385)->save($destinationPathMedium  . '/' .  $nameFile);

            $imgMin = Image::make($request->cover)->resize(null, 207, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(360, 207)->save($destinationPathMin  . '/' .  $nameFile);

            if (!$img && !$imgMedium && !$imgMin) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        if ($request->content) {
            $content = $request->content;
            $dom = new \DOMDocument();
            $dom->encoding = 'utf-8';
            $dom->loadHTML(utf8_decode($content), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $img = $image->getAttribute('src');
                if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                    list($type, $img) = explode(';', $img);
                    list(, $img) = explode(',', $img);
                    $imageData = base64_decode($img);
                    $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                    $path = storage_path() . '/app/public/blog/content/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/blog/content/' . $image_name));
                }
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
        }

        $data['uri'] = Str::slug($request->title);
        $post = Blog::create($data);

        if ($post->save()) {

            $categories = $request->categories;
            if ($categories && count($categories) > 0) {
                $categories = BlogCategory::whereIn('id', $categories)->pluck('id');
                foreach ($categories as $category) {
                    $pivot = new BlogCategoriesPivot();
                    $pivot->create([
                        'blog_id' => $post->id,
                        'blog_category_id' => $category
                    ]);
                }
            }

            return redirect()
                ->route('admin.blog.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        CheckPermission::checkAuth('Editar Blog');

        $post = Blog::find($id);
        if (!$post) {
            abort(403, 'Acesso não autorizado');
        }

        $categories = BlogCategory::orderBy('title')->get();
        return view('admin.blog.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, $id)
    {
        CheckPermission::checkAuth('Editar Blog');

        $post = Blog::find($id);

        if (!$post) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)) . time();
            $imagePath = storage_path() . '/app/public/blog/' . $post->cover;
            $imagePathMedium = storage_path() . '/app/public/blog/medium/' . $post->cover;
            $imagePathMin = storage_path() . '/app/public/blog/min/' . $post->cover;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            if (File::isFile($imagePathMedium)) {
                unlink($imagePathMedium);
            }

            if (File::isFile($imagePathMin)) {
                unlink($imagePathMin);
            }

            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $data['cover'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/blog';
            $destinationPathMedium = storage_path() . '/app/public/blog/medium';
            $destinationPathMin = storage_path() . '/app/public/blog/min';
            $destinationPathContent = storage_path() . '/app/public/blog/content';

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 755, true);
            }

            if (!file_exists($destinationPathMedium)) {
                mkdir($destinationPathMedium, 755, true);
            }

            if (!file_exists($destinationPathMin)) {
                mkdir($destinationPathMin, 755, true);
            }

            if (!file_exists($destinationPathContent)) {
                mkdir($destinationPathContent, 755, true);
            }

            $img = Image::make($request->cover)->resize(null, 489, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(860, 489)->save($destinationPath . '/' . $nameFile);

            $imgMedium = Image::make($request->cover)->resize(null, 385, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(675, 385)->save($destinationPathMedium  . '/' .  $nameFile);

            $imgMin = Image::make($request->cover)->resize(null, 207, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(360, 207)->save($destinationPathMin  . '/' .  $nameFile);

            if (!$img && !$imgMedium && !$imgMin) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        if ($request->content) {
            $content = $request->content;
            $dom = new \DOMDocument();
            $dom->encoding = 'utf-8';
            $dom->loadHTML(utf8_decode($content), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $img = $image->getAttribute('src');
                if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                    list($type, $img) = explode(';', $img);
                    list(, $img) = explode(',', $img);
                    $imageData = base64_decode($img);
                    $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                    $path = storage_path() . '/app/public/blog/content/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/blog/content/' . $image_name));
                }
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
        }

        $post['uri'] = Str::slug($request->title);

        if ($post->update($data)) {

            $categories = $request->categories;
            if ($categories && count($categories) > 0) {
                $categories = BlogCategory::whereIn('id', $categories)->pluck('id');
                foreach ($categories as $category) {
                    $pivot = new BlogCategoriesPivot();
                    $pivot->firstOrCreate([
                        'blog_id' => $post->id,
                        'blog_category_id' => $category
                    ]);
                }
            } else {
                BlogCategoriesPivot::where('blog_id', $post->id)->delete();
            }

            return redirect()
                ->route('admin.blog.index')
                ->with('success', 'Atualização realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CheckPermission::checkAuth('Excluir Blog');

        $post = Blog::find($id);

        if (!$post) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/blog/' . $post->cover;
        $imagePathMedium = storage_path() . '/app/public/blog/medium/' . $post->cover;
        $imagePathMin = storage_path() . '/app/public/blog/min/' . $post->cover;

        if ($post->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            if (File::isFile($imagePathMedium)) {
                unlink($imagePathMedium);
            }

            if (File::isFile($imagePathMin)) {
                unlink($imagePathMin);
            }

            BlogCategoriesPivot::where('blog_id', $post->id)->delete();
            $post->cover = null;
            $post->update();

            return redirect()
                ->route('admin.blog.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
