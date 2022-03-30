<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Custom;
use App\Events\GetRequestEvent;

class FormController extends Controller
{

	/**
     * @OA\Post(path="/api/input/proses",
     *   tags={"Input"},
     *   summary="Input data no handphone",
     *   description="Input data no handphone",
     *   operationId="inputproses",
     *   @OA\Parameter(
     *     name="no",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="no handphone",
     *   ),
     *   @OA\Parameter(
     *     name="providers",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="input id providers",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="sukses input no handphone",
     *     @OA\Schema(type="string"),
     *   )
     * )
     */
	public function prosesinput(Request $request)
	{
		$no_handphones 	= $request->no;
		$providers_id 	= $request->providers;
		
		$cek_inputan = \App\Models\Handphone::where('no_handphones',$no_handphones)
												->where('providers_id',$providers_id)
												->count();
		if($cek_inputan == 0)
		{
			$handphones_data = [
				'id_handphones'	=> Custom::autoIncrementKey('handphones','id_handphones'),
				'no_handphones'	=> $no_handphones,
				'providers_id'	=> $providers_id,
				'created_at'	=> date('Y-m-d H:i:s'),
				'updated_at'	=> date('Y-m-d H:i:s')
			];
			\App\Models\Handphone::insert($handphones_data);

			event(new GetRequestEvent($handphones_data));

			$hasil = [
				'status'	=> true,
				'pesan'		=> 'No '.$no_handphones.' berhasil disimpan',
			];
			return response()->json($hasil,200);
		}
		else
		{
			$hasil = [
				'status'	=> false,
				'pesan'		=> 'No '.$no_handphones.' sudah terdaftar',
			];

			return response()->json($hasil,200);
		}
	}

	/**
     * @OA\Get(path="/api/input/auto",
     *   tags={"Input"},
     *   summary="Input data auto no handphone",
     *   description="Input data auto no handphone",
     *   operationId="inputauto",
     *   @OA\Response(
     *     response=200,
     *     description="sukses input no handphone",
     *     @OA\Schema(type="string"),
     *   )
     * )
     */
	public function autohandphone()
	{
		$no_prefix 		= ['0812', '0813', '0814', '0815', '0816', '0817', '0818', '0819', '0909', '0908'];
		$no_handphones 	= $no_prefix[array_rand($no_prefix)].''.Custom::randomNumberSequence('25');

		$cek_inputan = \App\Models\Handphone::where('no_handphones',$no_handphones)
												->where('providers_id',1)
												->count();
		if($cek_inputan == 0)
		{
			$handphones_data = [
				'id_handphones'	=> Custom::autoIncrementKey('handphones','id_handphones'),
				'no_handphones'	=> $no_handphones,
				'providers_id'	=> 1,
				'created_at'	=> date('Y-m-d H:i:s'),
				'updated_at'	=> date('Y-m-d H:i:s')
			];
			\App\Models\Handphone::insert($handphones_data);

			$hasil = [
				'status'	=> true,
				'pesan'		=> 'No '.$no_handphones.' berhasil disimpan',
			];
			return response()->json($hasil,200);
		}
		else
		{
			$hasil = [
				'status'	=> false,
				'pesan'		=> 'No '.$no_handphones.' sudah terdaftar',
			];

			return response()->json($hasil,200);
		}
	}

	/**
     * @OA\Get(path="/api/output",
     *   tags={"Output"},
     *   summary="Tampil data output",
     *   description="Tampil data output",
     *   operationId="output",
     *   @OA\Response(
     *     response=200,
     *     description="sukses tampil output",
     *     @OA\Schema(type="string"),
     *   )
     * )
     */
	public function tampiloutput()
	{
		$ambil_handphones = \App\Models\Handphone::orderBy('no_handphones')
												->get();
		if(!$ambil_handphones->isEmpty())
		{
			$ambil_ganjil = [];
			$ambil_genap = [];
			foreach($ambil_handphones as $handphones)
			{
				if($handphones->no_handphones % 2 == 0)
				{
					$ambil_genap[] = [
						'id' => $handphones->id_handphones,
						'no' => $handphones->no_handphones
					];
				}
				else
				{
					$ambil_ganjil[] = [
						'id' => $handphones->id_handphones,
						'no' => $handphones->no_handphones
					];
				}
			}

			$handphones_data = [
				'genap'		=> $ambil_genap,
				'ganjil'	=> $ambil_ganjil,
			];

			$hasil = [
				'status'	=> true,
				'pesan'		=> $handphones_data
			];
			return response()->json($hasil,200);
		}
		else
		{
			$hasil = [
				'status'	=> false,
				'pesan'		=> 'tidak ada data',
			];

			return response()->json($hasil,200);
		}
	}

	/**
     * @OA\Post(path="/api/output/detail",
     *   tags={"Output"},
     *   summary="Detail data handphone",
     *   description="Detail data handphone",
     *   operationId="detail",
     *   @OA\Parameter(
     *     name="id_handphones",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="id handphone",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="sukses detail handphone",
     *     @OA\Schema(type="string"),
     *   )
     * )
     */
	public function detailoutput(Request $request)
	{
		$id_handphones = $request->id_handphones;
		$ambil_handphones = \App\Models\Handphone::where('id_handphones',$id_handphones)
													->first();
		if(!empty($ambil_handphones))
		{
			$hasil = [
				'status'	=> true,
				'pesan'		=> $ambil_handphones,
			];

			return response()->json($hasil,200);
		}
		else
		{
			$hasil = [
				'status'	=> false,
				'pesan'		=> 'tidak ada data',
			];

			return response()->json($hasil,200);
		}
	}

	/**
     * @OA\Post(path="/api/output/edit",
     *   tags={"Output"},
     *   summary="Edit data handphone",
     *   description="Edit data handphone",
     *   operationId="edit",
     *   @OA\Parameter(
     *     name="id_handphones",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="id handphone",
     *   ),
     *   @OA\Parameter(
     *     name="no_handphones",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="no handphone",
     *   ),
     *   @OA\Parameter(
     *     name="providers_id",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="id provider",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="sukses edit handphone",
     *     @OA\Schema(type="string"),
     *   )
     * )
     */
	public function editoutput(Request $request)
	{
		$id_handphones = $request->id_handphones;
		$ambil_handphones = \App\Models\Handphone::where('id_handphones',$id_handphones)
													->first();
		if(!empty($ambil_handphones))
		{
			
			$handphone_data = [
				'no_handphones'	=> $request->no_handphones,
				'providers_id'	=> $request->providers_id,
				'updated_at'	=> date('Y-m-d H:i:s'),
			];
			\App\Models\Handphone::where('id_handphones',$id_handphones)
								->update($handphone_data);

			$hasil = [
				'status'	=> true,
				'pesan'		=> 'No '.$ambil_handphones->no_handphones.' berhasil diedit.',
			];

			return response()->json($hasil,200);
		}
		else
		{
			$hasil = [
				'status'	=> false,
				'pesan'		=> 'tidak ada data',
			];

			return response()->json($hasil,200);
		}
	}


	/**
     * @OA\Post(path="/api/output/delete",
     *   tags={"Output"},
     *   summary="Hapus data handphone",
     *   description="Hapus data handphone",
     *   operationId="hapus",
     *   @OA\Parameter(
     *     name="id_handphones",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="id handphone",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="sukses hapus handphone",
     *     @OA\Schema(type="string"),
     *   )
     * )
     */
	public function deleteoutput(Request $request)
	{
		$id_handphones = $request->id_handphones;
		$ambil_handphones = \App\Models\Handphone::where('id_handphones',$id_handphones)
													->first();
		if(!empty($ambil_handphones))
		{
			\App\Models\Handphone::where('id_handphones',$id_handphones)
								->delete();
			$hasil = [
				'status'	=> true,
				'pesan'		=> 'No '.$ambil_handphones->no_handphones.' berhasil dihapus.',
			];

			return response()->json($hasil,200);
		}
		else
		{
			$hasil = [
				'status'	=> false,
				'pesan'		=> 'tidak ada data',
			];

			return response()->json($hasil,200);
		}
	}

}