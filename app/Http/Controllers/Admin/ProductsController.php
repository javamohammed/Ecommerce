<?php
namespace App\Http\Controllers\Admin;
use App\Model\Product;
use App\DataTables\ProductsDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
class ProductsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ProductsDatatable $product) {
		return $product->render('admin.products.index', ['title' => trans('admin.products')]);
    }

    public function upload_file($pid){
        if (request()->hasFile('file')) {

			return up()->upload([
				'file'        => 'file',
                'path'        => 'products/'.$pid,
                'file_type'   => 'product',
				'upload_type' => 'files',
				'relation_id' => $pid,
			]);
		}
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
        $product = new Product();
        if(Product::where('title','')->count() == 0){
            $product = Product::create([
                'title' => ''
            ]);
        }else{
         $product = Product::where('title','')->first();
        }
        if(!empty($product)){
            $title = trans('admin.create_or_edit_product', ['title' => $product->title]);
            return view('admin.products.product',  compact('product', 'title'));
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store() {
		$data = $this->validate(request(),
			[
				'product_name_ar'     => 'required',
				'product_name_en'     => 'required',
				'mob'     => 'required',
				'code'     => 'required',
				'logo'     => 'required|'.v_image(),
			], [], [
				'product_name_ar'     => trans('admin.product_name_ar'),
				'product_name_en'     => trans('admin.product_name_en'),
				'mob'     => trans('admin.mob'),
				'code'     => trans('admin.code'),
				'logo'     => trans('admin.logo'),
			]);
		if (request()->hasFile('logo')) {

			$data['logo'] = up()->upload([
				'file'        => 'logo',
				'path'        => 'products',
				'upload_type' => 'single',
				'delete_file' => '',
			]);
		}
		Product::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$product = Product::find($id);
		$title = trans('admin.create_or_edit_product', ['title' => $product->title]);
        return view('admin.products.product',  compact('product', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $r, $id) {

		$data = $this->validate(request(),
			[
				'product_name_ar'     => 'required',
				'product_name_en'     => 'required',
				'mob'     => 'required',
				'code'     => 'required',
				//'logo'     => 'required|nullable|'.v_image(),
			], [], [
				'product_name_ar'     => trans('admin.product_name_ar'),
				'product_name_en'     => trans('admin.product_name_en'),
				'mob'     => trans('admin.mob'),
				'code'     => trans('admin.code'),
				'logo'     => trans('admin.logo'),
			]);
		if (request()->hasFile('logo')) {

			$data['logo'] = up()->upload([
				'file'        => 'logo',
				'path'        => 'products',
				'upload_type' => 'single',
				'delete_file' => Product::find($id)->logo,
			]);
		}
		Product::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('products'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$product = Product::find($id);
		Storage::delete($product->logo);
		$product->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$products = Product::find($id);
				Storage::delete($products->logo);
				$products->delete();
			}
		} else {
			$products = Product::find(request('item'));
			Storage::delete($products->logo);
			$products->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}
}
