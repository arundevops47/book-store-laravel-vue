<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			Book::truncate();
  
			$json = File::get("database/data/books.json");
			$results = json_decode($json);

			if($results) {
				foreach ($results->data as $key => $value) {
					Book::create([
						"title" => $value->title,
						"author" => $value->author,
						"genre" => $value->genre,
						"description" => $value->description,
						"isbn" => $value->isbn,
						"image" => $value->image,
						"published" => $value->published,		
						"publisher" => $value->publisher,						
						"created_at" => Carbon::now()->format('Y-m-d H:i:s'),
						"updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
					]);
				}
			}
    }
}
