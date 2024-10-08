<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CheckPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CertificateRequest;
use App\Models\Certificate;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        CheckPermission::checkAuth('Listar Certificados');

        $certificates = Certificate::all();

        if ($request->ajax()) {
            $token = csrf_token();

            return Datatables::of($certificates)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($token) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="certificates/'.$row->id.'/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>'.'<form method="POST" action="certificates/'.$row->id.'" class="btn btn-xs px-0"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="'.$token.'"><button class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" onclick="return confirm(\'Confirma a exclusão deste certificado?\')"><i class="fa fa-lg fa-fw fa-trash"></i></button></form>';

                    return $btn;
                })
                ->addColumn('cover', function ($row) {
                    return '<div class="d-flex justify-content-center align-items-center"><img src='.url('storage/certificates/min/'.$row->cover).' class="img-thumbnail d-block" width="287" height="215" alt="'.$row->title.'" title="'.$row->title.'"/></div>';
                })
                ->rawColumns(['action', 'cover'])
                ->make(true);
        }

        return view('admin.certificates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckPermission::checkAuth('Criar Certificados');

        return view('admin.certificates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificateRequest $request)
    {
        CheckPermission::checkAuth('Criar Certificados');

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)).time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $data['cover'] = $nameFile;

            $destinationPath = storage_path().'/app/public/certificates';
            $destinationPathMedium = storage_path().'/app/public/certificates/medium';
            $destinationPathMin = storage_path().'/app/public/certificates/min';

            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 755, true);
            }

            if (! file_exists($destinationPathMedium)) {
                mkdir($destinationPathMedium, 755, true);
            }

            if (! file_exists($destinationPathMin)) {
                mkdir($destinationPathMin, 755, true);
            }

            $img = Image::make($request->cover)->resize(null, 565, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(800, 565)->save($destinationPath.'/'.$nameFile);

            $imgMedium = Image::make($request->cover)->resize(null, 410, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(574, 410)->save($destinationPathMedium.'/'.$nameFile);

            $imgMin = Image::make($request->cover)->resize(null, 205, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(287, 205)->save($destinationPathMin.'/'.$nameFile);

            if (! $img && ! $imgMedium && ! $imgMin) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $certificate = Certificate::create($data);

        if ($certificate->save()) {
            return redirect()
                ->route('admin.certificates.index')
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
        CheckPermission::checkAuth('Editar Certificados');

        $certificate = Certificate::find($id);
        if (! $certificate) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CertificateRequest $request, $id)
    {
        CheckPermission::checkAuth('Editar Certificados');

        $certificate = Certificate::find($id);

        if (! $certificate) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)).time();
            $imagePath = storage_path().'/app/public/certificates/'.$certificate->cover;
            $imagePathMedium = storage_path().'/app/public/certificates/medium/'.$certificate->cover;
            $imagePathMin = storage_path().'/app/public/certificates/min/'.$certificate->cover;

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

            $destinationPath = storage_path().'/app/public/certificates';
            $destinationPathMedium = storage_path().'/app/public/certificates/medium';
            $destinationPathMin = storage_path().'/app/public/certificates/min';

            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 755, true);
            }

            if (! file_exists($destinationPathMedium)) {
                mkdir($destinationPathMedium, 755, true);
            }

            if (! file_exists($destinationPathMin)) {
                mkdir($destinationPathMin, 755, true);
            }

            $img = Image::make($request->cover)->resize(null, 565, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(800, 565)->save($destinationPath.'/'.$nameFile);

            $imgMedium = Image::make($request->cover)->resize(null, 410, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(574, 410)->save($destinationPathMedium.'/'.$nameFile);

            $imgMin = Image::make($request->cover)->resize(null, 205, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(287, 205)->save($destinationPathMin.'/'.$nameFile);

            if (! $img && ! $imgMedium && ! $imgMin) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        if ($certificate->update($data)) {
            return redirect()
                ->route('admin.certificates.index')
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
        CheckPermission::checkAuth('Excluir Certificados');

        $certificate = Certificate::find($id);

        if (! $certificate) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path().'/app/public/certificates/'.$certificate->cover;
        $imagePathMedium = storage_path().'/app/public/certificates/medium/'.$certificate->cover;
        $imagePathMin = storage_path().'/app/public/certificates/min/'.$certificate->cover;

        if ($certificate->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            if (File::isFile($imagePathMedium)) {
                unlink($imagePathMedium);
            }

            if (File::isFile($imagePathMin)) {
                unlink($imagePathMin);
            }

            $certificate->cover = null;
            $certificate->update();

            return redirect()
                ->route('admin.certificates.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
