<?php


namespace ZFTInfo\Book\Commands;

use Illuminate\Console\Command;

use ZFTInfo\Book\Models\Book;
use ZFTInfo\Book\Models\Author;
use ZFTInfo\Book\Models\Publisher;
use Carbon\Carbon;

use DB;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the book migrate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('migrate');

        $this->info('migrate success');

        $this->seeder_demo();

        $this->seeder_menu();

    }


    protected function seeder_demo()
    {

        $author_info = Author::updateOrCreate(
            array(
                'name' => "周航",
            ),
            array(
                'name' => "周航",
                'name_en' => "",
                'country' => "",
                'created_at' =>Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            )
        );


        $publisher_info = Publisher::updateOrCreate(
            array(
                'name' => "百花文艺出版社",
            ),
            array(
                'name' => "百花文艺出版社",
                'cover' => "",
                'desc' => "",
                'created_at' =>Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            )
        );


        $publisher_info_2 = Publisher::updateOrCreate(
            array(
                'name' => "中信出版集团",
            ),
            array(
                'name' => "中信出版集团",
                'cover' => "",
                'desc' => "",
                'created_at' =>Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            )
        );

     

        $book_info = Book::updateOrCreate(
            array(
                'name' => "重新理解创业",
            ),
            array(
                'name' => "重新理解创业",
                'cover' => "http://img3m8.ddimg.cn/46/25/25535908-1_w_1.jpg",
                'douban_grade' => "8.1",
                'recommend_desc' => "创业者都认可的一本书",
                'status' => "1",
                'is_read' => "0",
                'is_buy' => "1",
                'isbn' => "",
                'link_dangdang' => "",
                'link_douban' => "",

                'created_at' =>Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            )
        );

        DB::table('t_book_author')->insert(array('book_id' => $book_info->id, 'author_id' => $author_info->id));

        DB::table('t_book_publisher')->insert(array('book_id' => $book_info->id, 'publisher_id' => $publisher_info->id));

        DB::table('t_book_publisher')->insert(array('book_id' => $book_info->id, 'publisher_id' => $publisher_info_2->id));



    }


    protected function seeder_menu()
    {
         $data = [
            [
                'id' => 100,
                'parent_id' => 0,
                'order' => 100,
                'title' => '图书',
                'icon' => 'fa-book',
                'uri' => '/',
            ],
            [
                'id' => 101,
                'parent_id' => 100,
                'order' => 101,
                'title' => '图书管理',
                'icon' => 'fa-book',
                'uri' => '/book',
            ],
            [
                'id' => 102,
                'parent_id' => 100,
                'order' => 102,
                'title' => '作者管理',
                'icon' => 'fa-book',
                'uri' => '/author',
            ],
            [
                'id' => 103,
                'parent_id' => 100,
                'order' => 103,
                'title' => '出版社管理',
                'icon' => 'fa-book',
                'uri' => '/publisher',
            ]

        ];

        DB::table('admin_menu')->insert($data);
    }
}
