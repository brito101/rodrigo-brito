<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CheckPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioCategoryRequest;
use App\Models\PortfolioCategoriesPivot;
use App\Models\PortfolioCategory;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class PortfolioCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        CheckPermission::checkAuth('Listar Categorias do Portfólio');

        $categories = PortfolioCategory::all();

        if ($request->ajax()) {
            $token = csrf_token();

            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($token) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="portfolio-categories/'.$row->id.'/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>'.'<form method="POST" action="portfolio-categories/'.$row->id.'" class="btn btn-xs px-0"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="'.$token.'"><button class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" onclick="return confirm(\'Confirma a exclusão desta categoria?\')"><i class="fa fa-lg fa-fw fa-trash"></i></button></form>';

                    return $btn;
                })
                ->addColumn('cover', function ($row) {
                    return '<div class="d-flex justify-content-center align-items-center"><img src='.url('storage/portfolio-categories/min/'.$row->cover).' class="img-thumbnail d-block" width="360" height="207" alt="'.$row->title.'" title="'.$row->title.'"/></div>';
                })
                ->addColumn('portfolios', function ($row) {
                    return $row->portfolios->count();
                })
                ->rawColumns(['action', 'cover', 'portfolios'])
                ->make(true);
        }

        return view('admin.portfolio.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckPermission::checkAuth('Criar Categorias do Portfólio');

        return view('admin.portfolio.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioCategoryRequest $request)
    {
        CheckPermission::checkAuth('Criar Categorias do Portfólio');

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)).time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $data['cover'] = $nameFile;

            $destinationPath = storage_path().'/app/public/portfolio-categories';
            $destinationPathMedium = storage_path().'/app/public/portfolio-categories/medium';
            $destinationPathMin = storage_path().'/app/public/portfolio-categories/min';

            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 755, true);
            }

            if (! file_exists($destinationPathMedium)) {
                mkdir($destinationPathMedium, 755, true);
            }

            if (! file_exists($destinationPathMin)) {
                mkdir($destinationPathMin, 755, true);
            }

            $img = Image::make($request->cover)->resize(null, 490, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(860, 490)->save($destinationPath.'/'.$nameFile);

            $imgMedium = Image::make($request->cover)->resize(null, 385, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(675, 385)->save($destinationPathMedium.'/'.$nameFile);

            $imgMin = Image::make($request->cover)->resize(null, 207, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(360, 207)->save($destinationPathMin.'/'.$nameFile);

            if (! $img && ! $imgMedium && ! $imgMin) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $data['uri'] = Str::slug($request->title);
        $category = PortfolioCategory::create($data);

        if ($category->save()) {
            return redirect()
                ->route('admin.portfolio-categories.index')
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
        CheckPermission::checkAuth('Editar Categorias do Portfólio');

        $category = PortfolioCategory::find($id);
        if (! $category) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.portfolio.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioCategoryRequest $request, $id)
    {
        CheckPermission::checkAuth('Editar Categorias do Portfólio');

        $category = PortfolioCategory::find($id);

        if (! $category) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)).time();
            $imagePath = storage_path().'/app/public/portfolio-categories/'.$category->cover;
            $imagePathMedium = storage_path().'/app/public/portfolio-categories/medium/'.$category->cover;
            $imagePathMin = storage_path().'/app/public/portfolio-categories/min/'.$category->cover;

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

            $destinationPath = storage_path().'/app/public/portfolio-categories';
            $destinationPathMedium = storage_path().'/app/public/portfolio-categories/medium';
            $destinationPathMin = storage_path().'/app/public/portfolio-categories/min';

            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 755, true);
            }

            if (! file_exists($destinationPathMedium)) {
                mkdir($destinationPathMedium, 755, true);
            }

            if (! file_exists($destinationPathMin)) {
                mkdir($destinationPathMin, 755, true);
            }

            $img = Image::make($request->cover)->resize(null, 490, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(860, 490)->save($destinationPath.'/'.$nameFile);

            $imgMedium = Image::make($request->cover)->resize(null, 385, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(675, 385)->save($destinationPathMedium.'/'.$nameFile);

            $imgMin = Image::make($request->cover)->resize(null, 207, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(360, 207)->save($destinationPathMin.'/'.$nameFile);

            if (! $img && ! $imgMedium && ! $imgMin) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $data['uri'] = Str::slug($request->title);

        if ($category->update($data)) {
            return redirect()
                ->route('admin.portfolio-categories.index')
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
        CheckPermission::checkAuth('Excluir Categorias do Portfólio');

        $category = PortfolioCategory::find($id);

        if (! $category) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path().'/app/public/portfolio-categories/'.$category->cover;
        $imagePathMedium = storage_path().'/app/public/portfolio-categories/medium/'.$category->cover;
        $imagePathMin = storage_path().'/app/public/portfolio-categories/min/'.$category->cover;

        if ($category->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            if (File::isFile($imagePathMedium)) {
                unlink($imagePathMedium);
            }

            if (File::isFile($imagePathMin)) {
                unlink($imagePathMin);
            }

            PortfolioCategoriesPivot::where('portfolio_category_id', $category->id)->delete();
            $category->cover = null;
            $category->update();

            return redirect()
                ->route('admin.portfolio-categories.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
