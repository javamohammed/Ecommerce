<?php
namespace App\Http\Controllers\Admin;

use App\Model\Product;
use App\Model\Size;
use App\Model\Weight;
use App\Model\OtherData;
use App\Model\MallProduct;
use App\DataTables\ProductsDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class ProductsController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index(ProductsDatatable $product)
    {
        return $product->render('admin.products.index', ['title' => trans('admin.products')]);
    }


    public function load_weight_size()
    {
        if (request()->ajax() and request()->has('dep_id')) {
            $dep_list = array_diff(explode(',', get_parent(request('dep_id'))), [request('dep_id')]);
            /*
            $size_1 = Size::where('is_public', 'yes')->whereIn('department_id', $dep_list)->pluck('name_'.session('lang'),'id');
            $size_2 = Size::where('department_id', request('dep_id'))->pluck('name_'.session('lang'),'id');
            //$sizes = array_merge(json_decode( $size_1, true), json_decode($size_2, true));
            $sizes = array_merge((array) $size_1, (array) $size_2);*/
            $sizes = Size::where('is_public', 'yes')
                ->whereIn('department_id', $dep_list)
                ->orWhere('department_id', request('dep_id'))
                ->pluck('name_' . session('lang'), 'id');
            //print_r( $size_1);
            //print_r( $sizes);
            //exit();
            $weights = Weight::pluck('name_' . session('lang'), 'id');
            $product = Product::find(request('product_id'));
            //print_r( $product);exit();
            return view('admin.products.ajax.size_weight', compact('sizes', 'weights', 'product'))->render();
        } else {
            return 'الرجاء ختيار قسم';
        }
    }
    public function update_product_image($id)
    {
        $product = Product::where('id', $id)->update([
            'photo' =>  up()->upload([
                'file'        => 'file',
                'path'        => 'products/' . $id,
                'upload_type' => 'single',
                'delete_file' => '',
            ])
        ]);
        return response(['status' => true],  200);
    }
    public function delete_main_image($id)
    {
        $product = Product::find($id);
        Storage::delete($product->photo);
        $product->photo = null;
        $product->save();
        return response(['status' => true],  200);
    }

    public function upload_file($pid)
    {
        if (request()->hasFile('file')) {

            $fid = up()->upload([
                'file'        => 'file',
                'path'        => 'products/' . $pid,
                'file_type'   => 'product',
                'upload_type' => 'files',
                'relation_id' => $pid,
            ]);
            return response(['status' => true, 'id' => $fid], 200);
        }
    }

    public function delete_file()
    {
        if (request()->has('id')) {

            up()->delete(request('id'));
        }
    }

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function create()
    {
        $product = new Product();
        if (Product::where('title', '')->count() == 0) {
            $product = Product::create([
                'title' => ''
            ]);
        } else {
            $product = Product::where('title', '')->first();
        }
        if (!empty($product)) {
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
    public function store()
    {
        dd(request());
        $data = $this->validate(
            request(),
            [
                'product_name_ar'     => 'required',
                'product_name_en'     => 'required',
                'mob'     => 'required',
                'code'     => 'required',
                'logo'     => 'required|' . v_image(),
            ],
            [],
            [
                'product_name_ar'     => trans('admin.product_name_ar'),
                'product_name_en'     => trans('admin.product_name_en'),
                'mob'     => trans('admin.mob'),
                'code'     => trans('admin.code'),
                'logo'     => trans('admin.logo'),
            ]
        );
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
    public function show($id)
    {
        //
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
    public function edit($id)
    {
        $product = Product::find($id);
        //dd($product);
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
    public function update($id)
    {
        $data = $this->validate(
            request(),
            [
                'title' => 'required',
                'content' => 'required',
                'department_id' => 'required|numeric',
                'trade_id' => 'required|numeric',
                'manu_id' => 'required|numeric',
                'color_id' => 'sometimes|nullable|numeric',
                'size_id' => 'sometimes|nullable|numeric',
                'currency_id' => 'sometimes|nullable|numeric',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'start_at' => 'required|date',
                'end_at' => 'required|date',
                'start_offer_at' => 'sometimes|nullable|date',
                'end_offer_at' => 'sometimes|nullable|date',
                'price_offer' => 'sometimes|nullable|numeric',
                'weight' => 'sometimes|nullable',
                'size' => 'sometimes|nullable',
                'weight_id' => 'sometimes|nullable',
                'status' => 'sometimes|nullable|in:pending, refused, active',
                'reason' => 'sometimes|nullable|numeric',
            ],
            [],
            [
                'title' => trans('admin.product_title'),
                'content' => trans('admin.product_content'),
                'department_id' => trans('admin.department'),
                'trade_id' => trans('admin.trade_id'),
                'manu_id' => trans('admin.manu_id'),
                'color_id' => trans('admin.color_id'),
                'size_id' => trans('admin.size_id'),
                'currency_id' => trans('admin.currency_id'),
                'price' => trans('admin.price'),
                'stock' => trans('admin.stock'),
                'start_at' => trans('admin.start_at'),
                'end_at' => trans('admin.end_at'),
                'start_offer_at' => trans('admin.start_offer_at'),
                'end_offer_at' => trans('admin.end_offer_at'),
                'price_offer' => trans('admin.price_offer'),
                'weight' => trans('admin.weight'),
                'size' => trans('admin.size'),
                'weight_id' => trans('admin.weight_id'),
                'status' => trans('admin.status'),
                'reason' => trans('admin.reason'),
            ]
        );
        if (request()->has('mall')) {
            MallProduct::where('product_id', $id)->delete();
            foreach (request('mall') as $mall) {
                # code...
                MallProduct::create([
                    'product_id' => $id,
                    'mall_id' => $mall
                ]);
            }
        }
        if (request()->has('input_value') && request()->has('input_key')) {
            $i = 0;
            OtherData::where('product_id', $id)->delete();
            foreach (request('input_key') as $key) {
                $data_value = !empty(request('input_value')[$i]) ?  request('input_value')[$i] : '';
                OtherData::create([
                    'product_id' => $id,
                    'data_key' => $key,
                    'data_value' => $data_value,
                ]);
                $i++;
            }
            //$data['other_data'] = rtrim($other_data,'|');
        }
        Product::where('id', $id)->update($data);
        return response(['status' => true, 'message' => 'تم تحديث البيانات بنجاح'], 200);
    }

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete($product->logo);
        $product->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('products'));
    }

    public function multi_delete()
    {
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
