## How to run

create .env file, paste content from .env.example to .env

composer install
yarn install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan elasticsearch:ping   <!-- check if elasticsearch working -->
php artisan generate:bookindex   <!-- generate index of all books in books table -->

1. In one terminal window run server as 
php artisan serve

2. In another terminal window run npm for dev (not for production)
yarn dev


default admin login 
email: admin@admin.com
password: password


## API

http://localhost:8000/api/books

http://localhost:8000/api/books?q=&perPage=10&page=1&sortBy=asc


## Elasticsearch Installation in ubuntu

// elasticsearch version 8
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.6.1-linux-x86_64.tar.gz
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.6.1-linux-x86_64.tar.gz.sha512
shasum -a 512 -c elasticsearch-8.6.1-linux-x86_64.tar.gz.sha512 
tar -xzf elasticsearch-8.6.1-linux-x86_64.tar.gz
cd elasticsearch-8.6.1/ 
echo 'export ES_HOME="$HOME/elasticsearch-8.6.1/"' >> ~/.bashrc
echo 'export PATH="$ES_HOME/bin:$PATH"' >> ~/.bashrc
exec $SHELL

## Run Elasticsearch

`open terminal and run below command`

elasticsearch

`Open another terminal window and check if elasticsearch running by`

curl -X GET 'http://localhost:9200'

`check elasticsearch runing in browser `

localhost:9200



http://localhost:9200/<index_name>/_doc/<id>

http://localhost:9200/books/_doc/1


Delete index

curl -X DELETE 'http://localhost:9200/<name_of_index>'
e.g.
curl -X DELETE 'http://localhost:9200/books'



## References

https://www.elastic.co
https://www.elastic.co/guide/index.html
https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html