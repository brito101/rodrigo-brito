<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CheckPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Models\Portfolio;
use App\Models\PortfolioCategoriesPivot;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use DataTables;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        CheckPermission::checkAuth('Listar Portfolio');

        $portfolios = Portfolio::all();

        if ($request->ajax()) {
            $token = csrf_token();

            return Datatables::of($portfolios)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($token) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" target="_blank" href="' . route('site.portfolio.post', ['uri' => $row->uri])  . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="portfolio/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<form method="POST" action="portfolio/' . $row->id . '" class="btn btn-xs px-0"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' . $token . '"><button class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" onclick="return confirm(\'Confirma a exclusão deste projeto?\')"><i class="fa fa-lg fa-fw fa-trash"></i></button></form>';
                    return $btn;
                })
                ->addColumn('cover', function ($row) {
                    return '<div class="d-flex justify-content-center align-items-center"><img src=' . url('storage/portfolio/min/' . $row->cover) .  ' class="img-thumbnail d-block" width="360" height="207" alt="' . $row->title . '" title="' . $row->title . '"/></div>';
                })
                ->rawColumns(['action', 'cover'])
                ->make(true);
        }

        return view('admin.portfolio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckPermission::checkAuth('Criar Portfolio');
        $categories = PortfolioCategory::orderBy('title')->get();
        return view('admin.portfolio.create', \compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        CheckPermission::checkAuth('Criar Portfolio');

        $data = $request->all();
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)) . time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $data['cover'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/portfolio';
            $destinationPathMedium = storage_path() . '/app/public/portfolio/medium';
            $destinationPathMin = storage_path() . '/app/public/portfolio/min';
            $destinationPathContent = storage_path() . '/app/public/portfolio/content';

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

            $img = Image::make($request->cover)->resize(null, 490, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(860, 490)->save($destinationPath . '/' . $nameFile);

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
                    $path = storage_path() . '/app/public/portfolio/content/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/portfolio/content/' . $image_name));
                }
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
        }

        $data['uri'] = Str::slug($request->title);
        $portfolio = Portfolio::create($data);

        if ($portfolio->save()) {

            $categories = $request->categories;
            if ($categories && count($categories) > 0) {
                $categories = PortfolioCategory::whereIn('id', $categories)->pluck('id');
                foreach ($categories as $category) {
                    $pivot = new PortfolioCategoriesPivot();
                    $pivot->create([
                        'portfolio_id' => $portfolio->id,
                        'portfolio_category_id' => $category
                    ]);
                }
            }

            return redirect()
                ->route('admin.portfolio.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        CheckPermission::checkAuth('Editar Portfolio');

        $portfolio = Portfolio::find($id);
        if (!$portfolio) {
            abort(403, 'Acesso não autorizado');
        }

        $categories = PortfolioCategory::orderBy('title')->get();
        return view('admin.portfolio.edit', compact('portfolio', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioRequest $request, $id)
    {
        CheckPermission::checkAuth('Editar Portfolio');

        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)) . time();
            $imagePath = storage_path() . '/app/public/portfolio/' . $portfolio->cover;
            $imagePathMedium = storage_path() . '/app/public/portfolio/medium/' . $portfolio->cover;
            $imagePathMin = storage_path() . '/app/public/portfolio/min/' . $portfolio->cover;

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

            $destinationPath = storage_path() . '/app/public/portfolio';
            $destinationPathMedium = storage_path() . '/app/public/portfolio/medium';
            $destinationPathMin = storage_path() . '/app/public/portfolio/min';
            $destinationPathContent = storage_path() . '/app/public/portfolio/content';

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

            $img = Image::make($request->cover)->resize(null, 490, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(860, 490)->save($destinationPath . '/' . $nameFile);

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
                    $path = storage_path() . '/app/public/portfolio/content/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/portfolio/content/' . $image_name));
                }
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
        }

        $portfolio['uri'] = Str::slug($request->title);

        if ($portfolio->update($data)) {

            $categories = $request->categories;
            if ($categories && count($categories) > 0) {
                $categories = PortfolioCategory::whereIn('id', $categories)->pluck('id');
                foreach ($categories as $category) {
                    $pivot = new PortfolioCategoriesPivot();
                    $pivot->firstOrCreate([
                        'portfolio_id' => $portfolio->id,
                        'portfolio_category_id' => $category
                    ]);
                }
            } else {
                PortfolioCategoriesPivot::where('portfolio_id', $portfolio->id)->delete();
            }

            return redirect()
                ->route('admin.portfolio.index')
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
        CheckPermission::checkAuth('Excluir Portfolio');

        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/portfolio/' . $portfolio->cover;
        $imagePathMedium = storage_path() . '/app/public/portfolio/medium/' . $portfolio->cover;
        $imagePathMin = storage_path() . '/app/public/portfolio/min/' . $portfolio->cover;

        if ($portfolio->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            if (File::isFile($imagePathMedium)) {
                unlink($imagePathMedium);
            }

            if (File::isFile($imagePathMin)) {
                unlink($imagePathMin);
            }

            PortfolioCategoriesPivot::where('portfolio_id', $portfolio->id)->delete();
            $portfolio->cover = null;
            $portfolio->update();

            return redirect()
                ->route('admin.portfolio.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
