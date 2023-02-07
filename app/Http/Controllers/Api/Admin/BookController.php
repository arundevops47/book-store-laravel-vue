<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Elastic\Elasticsearch\Client;
use Carbon\Carbon;

class BookController extends Controller
{
	private $elastic;

	public function __construct(Client $client)
	{
		$this->elastic = $client;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getBooks(Request $req)
	{

		$qry = Book::select('*');
		if ($req->q != '') {
			if (config('services.elastic_search.enabled')) {
				$params = [
					'index' => env('ELASTICSEARCH_INDEX'),
					'body'  => [
						'query' => [
							'multi_match' => [
								'query' => $req->q,
							]
						]
					]
				];

				$response = $this->elastic->search($params);
				$bookIds = array_column($response['hits']['hits'], '_id');

				if (count($bookIds)) {
					$qry->whereIn('id', $bookIds);
				}
			} else {
				$qry->where('title', 'LIKE', "%{$req->q}%");
				// $qry->orWhere('author', 'LIKE', "%{$req->q}%");
			}
		}


		if ($req->sortBy == 'desc') {
			$qry->orderBy('id', 'desc');
		} else {
			$qry->orderBy('id', 'asc');
		}

		$results = $qry->paginate($req->perPage);

		return response()->json([
			'status' => 'OK',
			'code' => 200,
			'data' => $results,
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getBook($id)
	{
		$book = Book::find($id);

		return response()->json([
			'status' => 'OK',
			'code' => 200,
			'book' => $book,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $req)
	{
		try {
			$book = new Book();
			$book->title = $req->title;
			$book->author = $req->author;
			$book->description = $req->description;
			$book->image = $req->image;
			$book->genre = $req->genre;
			$book->isbn = $req->isbn;
			$book->published = $req->published;
			$book->publisher = $req->publisher;
			$book->save();

			return response()->json([
				'status' => 'OK',
				'code' => 200,
				'msg' => "New Book added successfully!",
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $req, $id)
	{
		try {
			$book = Book::where('id', $id)->first();
			$book->title = $req->title;
			$book->author = $req->author;
			$book->description = $req->description;
			$book->image = $req->image;
			$book->genre = $req->genre;
			$book->isbn = $req->isbn;
			$book->published = $req->published;
			$book->publisher = $req->publisher;
			$book->update();

			return response()->json([
				'status' => 'OK',
				'code' => 200,
				'msg' => "Book updated successfully!",
			]);
		} catch (\Throwable $th) {
			throw $th;
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
		$res = Book::destroy($id);

		return response()->json([
			'status' => 'OK',
			'code' => 200,
			'msg' => "Book deleted successfully!",
		]);
	}
}
