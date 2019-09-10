<?php

namespace ZFTInfo\Book\Http\Controllers;

use Illuminate\Routing\Controller;

#use ZFTInfo\Book\Book;

use ZFTInfo\Book\Models\Book;
use ZFTInfo\Book\Models\Author;
use ZFTInfo\Book\Models\Publisher;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BookController extends AdminController
{
    use HasResourceActions;

    /**
     * @var string
     */
    protected $title = '图书';
    protected $desc_index = '列表';
    protected $desc_show = '详情';
    protected $desc_edit = '编辑';
    protected $desc_create = '创建';
    protected $desc_url = '/book';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->description($this->desc_index)
            ->breadcrumb(
                ['text' => $this->title, 'url' => $this->desc_url],
                ['text' => $this->desc_index])
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description($this->desc_show)
            ->breadcrumb(
                ['text' => $this->title, 'url' => $this->desc_url],
                ['text' => $this->desc_show])
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description($this->desc_edit)
            ->breadcrumb(
                ['text' => $this->title, 'url' => $this->desc_url],
                ['text' => $this->desc_edit])
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->title)
            ->description($this->desc_create)
            ->breadcrumb(
                ['text' => $this->title, 'url' => $this->desc_url],
                ['text' => $this->desc_create])
            ->body($this->form($request));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Book());

        $grid->disableRowSelector();

        $grid->paginate(20);

        $grid->model()->orderBy('id', 'desc');

        $grid->id('序号')->sortable();

        $grid->cover('封面')->gallery(['zooming' => true, 'width' => 30, 'height' => 30]);

        $grid->name('名称');

        $grid->authors('作者')->pluck('name')->label();

        $grid->douban_grade('豆瓣评分');

        $grid->recommend_desc('推荐');

        $states = [
            "on" => ["value" => 1, "text" => "是", "color" => "success"],
            "off" => ["value" => 0, "text" => "否", "color" => "danger"],
        ];

        $grid->is_read('是否阅读')->switch($states);

        $grid->is_buy('是否购买')->switch($states);

        $grid->publishers('出版社')->pluck('name')->label();

        $grid->link_douban('豆瓣链接')->link();;

        // 搜索相关
        $grid->filter(function (Grid\Filter $filter) {

            $filter->disableIdFilter();

            $filter->like('name', '名称');

            $filter->like('author.name', '作者');

            $filter->like('publish.name', '出版社');

            $filter->scope('gte8', '豆瓣评分(大于等于8分)')->where('douban_grade', '>=', 8);
            $filter->scope('lt8', '豆瓣评分(小于8分)')->where('douban_grade', '<', 8);

            $filter->divider();

            $filter->scope('1', '已读')->where('is_read', '1');
            $filter->scope('0', '未读')->where('is_read', '0');

            $filter->scope('1', '已购')->where('is_buy', '1');
            $filter->scope('0', '未购')->where('is_buy', '0');


        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Book::findOrFail($id));

        $show->name('名称');

        $show->authors('作者信息')->as(function ($authors) {
            return $authors->pluck('name');
        })->label();

        $show->cover('封面')->image('', 60, 60);

        $show->douban_grade('豆瓣评分');

        $show->recommend_desc('推荐语');

        $show->is_read('是否阅读')->using(['1' => '是', '0' => '否'], '未知');

        $show->is_buy('是否购买')->using(['1' => '是', '0' => '否'], '未知');

        //$show->publishers('出版社')->pluck('name')->label();

        $show->publishers('出版社')->as(function ($publishers) {
            return $publishers->pluck('name');
        })->label();

        $show->isbn('ISBN');

        $show->link_dangdang('当当网链接');

        $show->link_douban('豆瓣网链接');

        $show->divider();

        $show->created_at('创建时间');

        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Book);

        $form->text('name', '名称')->rules('required');

        $form->multipleSelect('authors', '作者')->options(function ($id) {
            return Author::all()->pluck('name', 'id');
        });

        $form->url('cover', '封面URL')->rules('required');
        $form->text('douban_grade', '豆瓣评分')->rules('required');
        $form->text('recommend_desc', '推荐语');

        $states = [
              "on" => ["value" => 1, "text" => "是", "color" => "success"],
              "off" => ["value" => 0, "text" => "否", "color" => "danger"],
        ];
        $form->switch('is_read', '是否阅读')->states($states);

        $form->switch('is_buy', '是否购买')->states($states);

        $form->text('isbn', 'ISBN');

        $form->multipleSelect('publishers', '出版社')->options(Publisher::getSelectOptions());

        $form->url('link_dangdang', '当当网链接');
        $form->url('link_douban', '豆瓣网链接');

        return $form;
    }
}