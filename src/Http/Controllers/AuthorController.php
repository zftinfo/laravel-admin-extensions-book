<?php

namespace ZFTInfo\Book\Http\Controllers;

use Illuminate\Http\Request;

use ZFTInfo\Book\Models\Author;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Controllers\HasResourceActions;

use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class AuthorController extends AdminController
{

    use HasResourceActions;

    /**
     * @var string
     */
    protected $title = '作者';
    protected $desc_index = '列表';
    protected $desc_show = '详情';
    protected $desc_edit = '编辑';
    protected $desc_create = '创建';
    protected $desc_url = '/author';

    /**
     * Display a listing of the resource.
     *
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
     * Display the specified resource.
     *
     * @param  int $id
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
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
     * Show the form for creating a new resource.
     *
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
            ->body($this->form());
    }

    public function grid()
    {
        $grid = new Grid(new Author());

        $grid->disableRowSelector();

        $grid->paginate(20);

        $grid->id('序号')->sortable();

        $grid->name('名称');

        $grid->name_en('名称(英文)');

        $grid->desc('描述');

        //$grid->country()->name('国籍');

        $grid->country('国籍');

        // 搜索相关
        $grid->filter(function (Grid\Filter $filter) {

            $filter->disableIdFilter();

            $filter->like('name', '名称');

        });

        return $grid;
    }

    public function form()
    {
        $form = new Form(new Author);

        $form->text('name', '名称')->rules('required');

        $form->text('name_en', '名称(英文)');

        $form->text('desc', '描述');

        return $form;
    }


    public function detail($id)
    {
        $show = new Show(Author::findOrFail($id));

        $show->user()->as(function ($user) {
            return "{$user->name}";
        })->name('用户');


        $show->address('详细地址');

        $show->created_at('创建时间');

        $show->updated_at('更新时间');

        return $show;
    }

}
