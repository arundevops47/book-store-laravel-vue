<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Elastic\Elasticsearch\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

		$elastic_query = '';
		$elastic_fields = [];

		if (isset($req->q) && $req->q != '') {
			$elastic_fields[] = 'title';
			$elastic_query .= '('. $req->q.') OR ';
		}

		if (isset($req->genre) && $req->genre != '') {
			$elastic_fields[] = 'genre';
			$elastic_query .= $req->genre;
		}

		if (isset($req->authors) && $req->authors != '') {
			$elastic_fields[] = 'author';
			$elastic_query .= $req->authors;
		}

		if (isset($req->isbn) && $req->isbn != '') {
			$elastic_fields[] = 'isbn';
			$elastic_query .= $req->isbn;
		}

		if(count($elastic_fields)) {
			$elastic_query = rtrim($elastic_query, " OR ");

			if (config('services.elastic_search.enabled')) {
				$params = [
					'index' => env('ELASTICSEARCH_INDEX'),
					'body'  => [
						'query' => [
							'multi_match' => [
								'query' => $elastic_query,
								'fields' => $elastic_fields,
							],
						]
					]
				];
				$response = $this->elastic->search($params);
				$bookIds = array_column($response['hits']['hits'], '_id');
	
				if(count($bookIds)) {
					$qry->whereIn('id', $bookIds);			
				}
			}
			else {
				$qry->where('title', 'LIKE', "%{$req->q}%");
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

	public function getBookFilters(Request $req)
	{
		$genres = Book::groupBy('genre')->pluck('genre');
		$isbn = Book::groupBy('isbn')->pluck('isbn');
		$authors = Book::groupBy('author')->pluck('author');

		$filters = array(
			array('label' => 'Genre', 'value' => 'genre', 'items' => $genres->toArray()),
			array('label' => 'ISBN', 'value' => 'isbn', 'items' => $isbn->toArray()),
			array('label' => 'Authors', 'value' => 'authors', 'items' => $authors->toArray()),
		);

		return response()->json([
			'status' => 'OK',
			'code' => 200,
			'filters' => $filters,
		]);
	}
}