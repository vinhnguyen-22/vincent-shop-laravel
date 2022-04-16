<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
class CategoryProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function addPageCategory(){
        $this->AuthLogin();
        $category = CategoryProduct::where('category_parentId',0)->orderBy('category_id','DESC')->get();
        return view('admin.category.create')->with('category',$category);
    } 
    
    public function showAllCategory(){
        $this->AuthLogin();
        $list_category = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_parentId','DESC')->get();
        $manager_category_product = view('admin.category.list')->with('list_category',$list_category);
       
        return view('admin.admin_layout')->with('admin.category.list',$manager_category_product);
    }
    
    public function createCategory(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $category = new CategoryProduct();
        $category->category_name = $data['title'];
        $category->category_status = $data['status'];
        $category->category_desc = $data['desc'];
        $category->category_slug = $data['slug'];
        $category->category_keywords = $data['keywords'];
        $category->category_parentId = $data['parent'];
        $category->created_at = Carbon::now()->toDateTimeString();
        $category->updated_at = Carbon::now()->toDateTimeString();
        $category->save();

        session(['message'=>'Add category success']);
        return redirect('add-category-product'); 
    }   

    public function inactiveCategory ($cat_id){
        $this->AuthLogin();
        $category = CategoryProduct::find($cat_id);
        $category->category_status = 0;
        $category->save();
        session(['message'=> 'Don\'t show category']);
        return redirect('all-category-product');
    }
    
    public function activeCategory ($cat_id){
        $this->AuthLogin();
        $category = CategoryProduct::find($cat_id);
        $category->category_status = 1;
        $category->save();
        session(['message'=> 'show category']);
        return redirect('all-category-product');
    }
    
    public function editCategory($cat_id){
        $this->AuthLogin();
        $edit_category = CategoryProduct::find($cat_id);
        $category = CategoryProduct::where('category_id','<>',$cat_id)->orderBy('category_id','DESC')->get();
        return view('admin.category.edit')->with(compact('edit_category','category'));
    }
    
    public function updateCategory(Request $request,$cat_id){
        $this->AuthLogin();
    
        $data = $request->all();
        $category = CategoryProduct::find($cat_id);
        $category->category_name = $data['title'];
        $category->category_desc = $data['desc'];
        $category->category_slug = $data['slug'];
        $category->category_keywords = $data['keywords'];
        $category->category_parentId = $data['parent'];
        $category->updated_at = Carbon::now()->toDateTimeString();
        $category->save();

        session(['message'=>'Update category success']);
        return redirect('all-category-product'); 
    }  
    
    public function deleteCategory($cat_id){
        $this->AuthLogin();
        $category = CategoryProduct::find($cat_id);
        $category->delete();
        session(['message'=> 'Delete success']);
        return redirect('all-category-product');
    }
    
    public function arrangeCategory(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $cat_id = $data["page_id_array"];
        foreach ($cat_id as $key=> $val){
            $category = CategoryProduct::find($val);
            $category->category_order = $key;
            $category->save();
        }
        echo "updated category";
    }
    
    // end function admin page
    
    public function showCategoryPage($cat_slug, Request $request){
        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->orderBy('category_order','ASC')->where('category_status','1' )->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $pro_by_cat = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_category_product.category_slug',$cat_slug)->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

        $category_by_slug = CategoryProduct::where('category_slug',$cat_slug)->get();
        $min = Product::min('product_price');
        $max = Product::max('product_price');
        $max += 1000;        
        // SEO
        $meta_desc = '';
        $meta_keywords =''; 
        $meta_title = '';
        $url_canonical = $request->url();
        foreach ($pro_by_cat as $key => $val){
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->category_keywords;
            $meta_title = $val->category_name;
            $url_canonical = $request->url(); 
        }
        // SEO
        
        foreach ($category_by_slug as $key => $cat){
            $category_id = $cat->category_id;
        }
        //sort product by ...
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            switch ($sort_by) {
                case 'asc':
                    $pro_by_cat = Product::with('category')->where('category_id',$category_id)->where('product_status',1)->orderBy('product_price','ASC')->paginate(6)->appends(request()->query());
                    break;
                case 'desc':
                    $pro_by_cat = Product::with('category')->where('category_id',$category_id)->where('product_status',1)->orderBy('product_price','DESC')->paginate(6)->appends(request()->query());
                    break;
                case 'az':
                    $pro_by_cat = Product::with('category')->where('category_id',$category_id)->where('product_status',1)->orderBy('product_name','ASC')->paginate(6)->appends(request()->query());
                    break;
                case 'za':
                    $pro_by_cat = Product::with('category')->where('category_id',$category_id)->where('product_status',1)->orderBy('product_name','DESC')->paginate(6)->appends(request()->query());
                    break;        
                default:
                $pro_by_cat = Product::with('category')->where('category_id',$category_id)->where('product_status',1)->orderBy('product_price','ASC')->get();    
                break;
            }
        }elseif(isset($_GET['min_price']) && isset($_GET['max_price'])){
            $min_price = $_GET['min_price'];
            $max_price = $_GET['max_price'];
            $pro_by_cat = Product::with('category')->where('category_id',$category_id)->whereBetween('product_price',[$min_price, $max_price])->where('product_status',1)->get();    
        }else{
            $pro_by_cat = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_category_product.category_slug',$cat_slug)->get();
        }
        $cat_name = DB::table('tbl_category_product')->select('category_name')->where('tbl_category_product.category_slug',$cat_slug)->limit(1)->get(); 

        return view('pages.category.show')->with(compact('logo','catsPost','cats','brands','pro_by_cat','cat_name','meta_desc','meta_keywords','meta_title','url_canonical','slider','min','max'));
    } 

    //category tabs_product
    public function productTabs(Request $request) {
        $data = $request->all();
        $output = '';
        $product = Product::where('category_id',$data['cate_id'])->orderBy('product_id','DESC')->get();
        $product_count =$product->count();
        if($product_count>0){
            $output .= '
             <div class="tab-content">
                <div class="tab-pane fade active in" id="blazers" >
             ';
                foreach($product as $key=>$value){
                    $output .= '
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="'.url('public/uploads/product/'.$value->product_image).'" alt="" />
                                        <h2>'.number_format($value->product_price,0,',','.').'</h2>
                                        <p>'.$value->product_name.'</p>
                                        <a href="'.url('/product-detail/'.$value->product_slug).'" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </div>
                                </div>
                            </div>
                    </div>';
                }
            $output .= '</div>
                    </div>
            ';
            echo $output;
        }else{
             $output .= '
             <div class="tab-content">
                <div class="tab-pane fade active in" id="blazers" >
                    <h2>Chưa có sản phẩm trong tab này</h2>
                </div>
            </div>
             ';
        }
    }
}