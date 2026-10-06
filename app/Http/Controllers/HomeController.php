<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;

use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Press;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Service;
use App\Models\Events;
use App\Models\WebsiteData;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;      
use App\Mail\EnquiryAdminMail;             
use App\Mail\EnquiryCustomerMail;     





class HomeController extends Controller
{

   public function home()
{
    $data = [
        'menu'             => '',
        'sub_menu'         => '',
        'og_image'         => asset('assets/frontend/assets/imgs/slider/school-banner.jpg'),
        'meta_title'       => 'KK International School - Best CBSE School for Quality Education',
        'meta_keywords'    => 'KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School',
        'meta_description' => 'KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.',
    ];

    $slider = Slider::where('status', 'Active')->where('is_deleted', 0)->get();
    $testimonial = Testimonial::where('is_deleted', 0)->get();
    

    return view('frontend.index', compact('data', 'slider', 'testimonial'));
}
   
    public function about_us(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "About K. K. International School - Learning Today for a Better Tomorrow";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "K. K. International School, established in 2073 BS at Dharan-15, Sunsari, Nepal, is an A-Grade school dedicated to academic excellence, holistic development and joyful learning.";

   
    return view('frontend.about-us', compact('data'));
   }

 public function team()
{
    $data = [];
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $team = Press::where('is_deleted', 0)
        ->orderBy('id', 'desc')
        ->paginate(6); 

   
    return view('frontend.team', compact('data', 'team'));
}

 public function board_of_directors()
{
    $data = [];
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "Board of Directors - K. K. International School";
    $data['meta_keywords'] = "KK International School, Board of Directors, School Management, Dharan School";
    $data['meta_description'] = "Meet the Board of Directors guiding K. K. International School with vision, governance and commitment to quality education.";

    return view('frontend.board-of-directors', compact('data'));
}

   public function goal(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

     $goal = WebsiteData::where('is_deleted', 0)->where('status','Active')->where('type','Goal')->get();
   
 
    return view('frontend.goal', compact('data','goal'));
   }


   public function mission(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    
    $mission = WebsiteData::where('is_deleted', 0)->where('status','Active')->where('type','Mission')->get();
 
    return view('frontend.mission', compact('data','mission'));
   }

    public function director_message(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    
    $director_message = WebsiteData::where('is_deleted', 0)
        ->where('status','Active')
        ->whereIn('type', ['Chairman Message', 'Director Message'])
        ->get();
   
 
    return view('frontend.director-message', compact('data','director_message'));
   }


    public function principal_message(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    
    $principal_message = WebsiteData::where('is_deleted', 0)->where('status','Active')->where('type','Principal Message')->get();
    
 
    return view('frontend.principal-message', compact('data','principal_message'));
   }


   public function oath(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

   
    $oath = WebsiteData::where('is_deleted', 0)->where('status','Active')->where('type','Oath')->get();
   
 
    return view('frontend.oath', compact('data','oath'));
   }


    public function accomplishment(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

   $accomplishment = WebsiteData::where('is_deleted', 0)->where('status','Active')->where('type','Accomplishment')->get();

    return view('frontend.accomplishment', compact('data','accomplishment'));
   }

   public function gallery(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "Photo Gallery - KK International School";
    $data['meta_keywords'] = "KK International School, Photo Gallery, School Photos, Dharan School";
    $data['meta_description'] = "Explore photo gallery categories from K. K. International School.";

    $galleryCategories = GalleryCategory::where('is_deleted', 0)
        ->where('status', 'Active')
        ->withCount(['images as active_images_count' => fn($query) => $query->where('is_deleted', 0)->where('staus', 'Active')])
        ->orderBy('name')
        ->get();

    return view('frontend.gallery', compact('data', 'galleryCategories'));
   }

public function gallery_detail($slug)
{
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $category = GalleryCategory::where('slug', $slug)
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->firstOrFail();

    $data['meta_title'] = $category->name . " Gallery - KK International School";
    $data['meta_keywords'] = "KK International School, " . $category->name . ", Photo Gallery";
    $data['meta_description'] = "View " . $category->name . " images from K. K. International School.";

    $gallery = Gallery::where('is_deleted', 0)
        ->where('staus','Active')
        ->where('category_id', $category->id)
        ->orderBy('id', 'desc')
        ->paginate(9);

    return view('frontend.gallery-detail', compact('data', 'category', 'gallery'));
}

 public function video()
{
    $data = [];
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "Video Gallery - KK International School";
    $data['meta_keywords'] = "KK International School, Video Gallery, School Videos, Events";
    $data['meta_description'] = "Choose video gallery categories from K. K. International School.";

    $videoCategories = VideoCategory::where('is_deleted', 0)
        ->where('status', 'Active')
        ->withCount(['videos as active_videos_count' => fn($query) => $query->where('is_deleted', 0)->where('staus', 'Active')])
        ->orderBy('name')
        ->get();

    return view('frontend.video', compact('data', 'videoCategories'));
}

public function video_detail($slug)
{
    $data = [];
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $category = VideoCategory::where('slug', $slug)
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->firstOrFail();

    $data['meta_title'] = $category->name . " Videos - KK International School";
    $data['meta_keywords'] = "KK International School, " . $category->name . ", Video Gallery";
    $data['meta_description'] = "View " . $category->name . " videos from K. K. International School.";

    $video = Video::where('is_deleted', 0)
        ->where('staus', 'Active')
        ->where('category_id', $category->id)
        ->orderBy('id', 'desc')
        ->get();

    return view('frontend.video-detail', compact('data', 'category', 'video'));
}

   public function testimonial(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";


    $testimonial = DB::table('tbl_testimonial')
        ->where('is_deleted', 0)
        ->orderBy('id', 'desc')
        ->get();
 
    return view('frontend.testimonial', compact('data','testimonial'));
   }


   public function faq(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

 
     $faq = DB::table('tbl_faq')
        ->where('is_deleted', 0)
        ->orderBy('id', 'desc')
        ->get();
 
    return view('frontend.faq', compact('data','faq'));
   }

  
public function blogs(Request $request)
{
    $data['menu']            = "";
    $data['sub_menu']        = "";
    $data['og_image']        = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title']      = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords']   = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students.";
 
    $perPage      = 5;
    $search       = $request->get('search');
    $categorySlug = $request->get('category');
 
    // ---------- Main blog listing ----------
    $blogsQuery = DB::table('tbl_blog as b')
        ->join('tbl_blog_category as c', 'b.parent', '=', 'c.id')
        ->select(
            'b.id',
            'b.name as title',
            'b.slug',
            'b.image',
            'b.short_content',
            'b.tags',
            'b.view',
            'b.created_at',
            DB::raw('DATE(b.created_at) as blog_date'),
            'c.name as category_name',
            'c.slug as category_slug'
        )
        ->where('b.staus', 'Active')
        ->where('b.is_deleted', 0)
        ->where('c.staus', 'Active')
        ->where('c.is_deleted', 0);
 
    if ($search) {
        $blogsQuery->where(function ($q) use ($search) {
            $q->where('b.name', 'like', "%{$search}%")
              ->orWhere('b.short_content', 'like', "%{$search}%")
              ->orWhere('b.tags', 'like', "%{$search}%");
        });
    }
 
    if ($categorySlug) {
        $blogsQuery->where('c.slug', $categorySlug);
    }
 
    $blogs = $blogsQuery
        ->orderBy('b.created_at', 'desc')
        ->paginate($perPage)
        ->withQueryString();
 
    // ---------- Sidebar: Recent posts ----------
    $recentPosts = DB::table('tbl_blog as b')
        ->join('tbl_blog_category as c', 'b.parent', '=', 'c.id')
        ->select('b.name as title', 'b.slug', 'b.image', 'b.created_at', DB::raw('DATE(b.created_at) as blog_date'))
        ->where('b.staus', 'Active')
        ->where('b.is_deleted', 0)
        ->where('c.is_deleted', 0)
        ->orderBy('b.created_at', 'desc')
        ->limit(3)
        ->get();
 
    // ---------- Sidebar: Categories with post count ----------
    $categories = DB::table('tbl_blog_category as c')
        ->leftJoin('tbl_blog as b', function ($join) {
            $join->on('b.parent', '=', 'c.id')
                 ->where('b.staus', 'Active')
                 ->where('b.is_deleted', 0);
        })
        ->select('c.name', 'c.slug', DB::raw('COUNT(b.id) as post_count'))
        ->where('c.staus', 'Active')
        ->where('c.is_deleted', 0)
        ->groupBy('c.id', 'c.name', 'c.slug')
        ->orderBy('c.name')
        ->get();
 
    // ---------- Sidebar: Gallery (latest 6 blog images) ----------
    $galleryImages = DB::table('tbl_blog')
        ->select('image', 'slug')
        ->where('staus', 'Active')
        ->where('is_deleted', 0)
        ->whereNotNull('image')
        ->where('image', '!=', '')
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();
 
    // ---------- Sidebar: Upcoming Events ----------
    $upcomingEvents = DB::table('tbl_events')
        ->select('id', 'name', 'slug', 'event_date')
        ->where('staus', 'Active')
        ->where('is_deleted', 0)
        ->where('event_date', '>=', now())
        ->orderBy('event_date', 'asc')
        ->limit(3)
        ->get();
 
    return view('frontend.blogs', compact(
        'data',
        'blogs',
        'recentPosts',
        'categories',
        'galleryImages',
        'upcomingEvents',
        'search',
        'categorySlug'
    ));
}
 
 
public function blog_detail($slug)
    {
        // ---------- Fetch blog ----------
        $blog = DB::table('tbl_blog as b')
            ->join('tbl_blog_category as c', 'b.parent', '=', 'c.id')
            ->select(
                'b.id',
                'b.name as title',
                'b.slug',
                'b.image',
                'b.content',
                'b.short_content',
                'b.tags',
                'b.view',
                'b.created_at',
                DB::raw('DATE(b.created_at) as blog_date'),
                'b.parent as category_id',
                'c.name as category_name',
                'c.slug as category_slug'
            )
            ->where('b.slug', $slug)
            ->where('b.staus', 'Active')
            ->where('b.is_deleted', 0)
            ->where('c.is_deleted', 0)
            ->first();
     
        if (!$blog) {
            abort(404);
        }
     
        // ---------- Increment view ----------
        DB::table('tbl_blog')->where('id', $blog->id)->increment('view');
        
        // Refresh blog data
        $blog = DB::table('tbl_blog as b')
            ->join('tbl_blog_category as c', 'b.parent', '=', 'c.id')
            ->select(
                'b.id',
                'b.name as title',
                'b.slug',
                'b.image',
                'b.content',
                'b.short_content',
                'b.tags',
                'b.view',
                'b.created_at',
                DB::raw('DATE(b.created_at) as blog_date'),
                'b.parent as category_id',
                'c.name as category_name',
                'c.slug as category_slug'
            )
            ->where('b.slug', $slug)
            ->where('b.staus', 'Active')
            ->where('b.is_deleted', 0)
            ->where('c.is_deleted', 0)
            ->first();
     
        // ---------- Meta ----------
        $data['menu']            = "";
        $data['sub_menu']        = "";
        $data['og_image']        = $blog->image
                                        ? url('public/uploads/' . $blog->image)
                                        : url('assets/frontend/assets/imgs/slider/school-banner.jpg');
        $data['meta_title']      = $blog->title . " | KK International School";
        $data['meta_keywords']   = $blog->tags
                                        ? $blog->tags . ", KK International School, CBSE School"
                                        : "KK International School, Best School, CBSE School";
        $data['meta_description'] = $blog->short_content
                                        ?? "KK International School is committed to providing quality education.";
     
       
        $prevPost = DB::table('tbl_blog')
            ->select('name as title', 'slug')
            ->where('staus', 'Active')
            ->where('is_deleted', 0)
            ->where('created_at', '<', $blog->created_at)
            ->orderBy('created_at', 'desc')
            ->first();
     
      
        $nextPost = DB::table('tbl_blog')
            ->select('name as title', 'slug')
            ->where('staus', 'Active')
            ->where('is_deleted', 0)
            ->where('created_at', '>', $blog->created_at)
            ->orderBy('created_at', 'asc')
            ->first();
     
      
        $relatedPosts = DB::table('tbl_blog')
            ->select('name as title', 'slug', 'image', 'short_content', 'created_at', DB::raw('DATE(created_at) as blog_date'))
            ->where('parent', $blog->category_id)
            ->where('staus', 'Active')
            ->where('is_deleted', 0)
            ->where('slug', '!=', $slug)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
     
     
        $recentPosts = DB::table('tbl_blog as b')
            ->join('tbl_blog_category as c', 'b.parent', '=', 'c.id')
            ->select('b.name as title', 'b.slug', 'b.image', 'b.created_at', DB::raw('DATE(b.created_at) as blog_date'))
            ->where('b.staus', 'Active')
            ->where('b.is_deleted', 0)
            ->where('c.is_deleted', 0)
            ->orderBy('b.created_at', 'desc')
            ->limit(3)
            ->get();
     
        $categories = DB::table('tbl_blog_category as c')
            ->leftJoin('tbl_blog as b', function ($join) {
                $join->on('b.parent', '=', 'c.id')
                     ->where('b.staus', 'Active')
                     ->where('b.is_deleted', 0);
            })
            ->select('c.name', 'c.slug', DB::raw('COUNT(b.id) as post_count'))
            ->where('c.staus', 'Active')
            ->where('c.is_deleted', 0)
            ->groupBy('c.id', 'c.name', 'c.slug')
            ->orderBy('c.name')
            ->get();
     
        $galleryImages = DB::table('tbl_blog')
            ->select('image', 'slug')
            ->where('staus', 'Active')
            ->where('is_deleted', 0)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
     
        $upcomingEvents = DB::table('tbl_events')
            ->select('id', 'name', 'slug', 'event_date')
            ->where('staus', 'Active')
            ->where('is_deleted', 0)
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(3)
            ->get();
     
        return view('frontend.blog-detail', compact(
            'data',
            'blog',
         
            'prevPost',
            'nextPost',
            'relatedPosts',
            'recentPosts',
            'categories',
            'galleryImages',
            'upcomingEvents'
        ));
    }
    
  
public function service(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    
    // Fetch all active services - FIXED TYPO
    $services = Service::where('staus', 'Active')  // Keep as 'staus' if your column is named that way
                      ->where('is_deleted', 0)
                      ->orderBy('created_at', 'desc')
                      ->get();
    
    $data['meta_title'] = "Day Boarding Programs - K. K. International School";
    $data['meta_keywords'] = "KK International School, Day Boarding Program, Academic Support, Holistic Development, Dharan School";
    $data['meta_description'] = "Explore the KKIS Day Boarding Program with academic support, nutritious meals, supervised study and holistic development from 7:10 AM to 5:45 PM.";
    
    return view('frontend.service', compact('data', 'services'));
}

public function service_detail($slug){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    
    // Fetch service by slug
    $service = Service::where('slug', $slug)
                     ->where('staus', 'Active')  // Keep as 'staus' if your column is named that way
                     ->where('is_deleted', 0)
                     ->firstOrFail();
    
    $data['og_image'] = $service->image ? asset('uploads/' . $service->image) : url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    
    // Set meta data from service or defaults
    $data['meta_title'] = $service->meta_title ?? $service->name . " - KK International School";
    $data['meta_keywords'] = $service->meta_keywords ?? $service->name . ", KK International School, Best CBSE School, Quality Education";
    $data['meta_description'] = $service->meta_description ?? strip_tags(substr($service->short_content, 0, 160));
    
    return view('frontend.service-detail', compact('data', 'service'));
}

 public function events()
    {
        $data['menu'] = "";
        $data['sub_menu'] = "";
        $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

        // Get all events that are not deleted, ordered by event date
        $data['events'] = Events::where('is_deleted', 0)
            ->orderBy('event_date', 'desc')
            ->paginate(9); // 9 events per page

        $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
        $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
        $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

        return view('frontend.events', compact('data'));
    }

    public function event_detail($slug)
    {
        $data['menu'] = "";
        $data['sub_menu'] = "";
        $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

        // Get event by slug
        $data['event'] = Events::where('slug', $slug)
            ->where('is_deleted', 0)
            ->firstOrFail();

        $data['meta_title'] = $data['event']->name . " - KK International School";
        $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education";
        $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students.";

        return view('frontend.event-detail', compact('data'));
    }




   public function download(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

 
    return view('frontend.download', compact('data'));
   }

    public function contact_us(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');

    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

 
    return view('frontend.contact-us', compact('data'));
   }



   public function facilities(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $facilities = WebsiteData::where('type', 'Facilities')
        ->where('status', 'Active')
        ->where('is_deleted', '0')
        ->get();

    return view('frontend.facilities', compact('data', 'facilities'));
}


public function academic(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "Academics - KK International School";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $academic = WebsiteData::whereIn('type', ['Academics', 'Academic'])
        ->where('status', 'Active')
        ->where('is_deleted', '0')
        ->get();

    return view('frontend.academic', compact('data', 'academic'));
}


public function programs(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $programs = WebsiteData::where('type', 'Programs')
        ->where('status', 'Active')
        ->where('is_deleted', '0')
        ->get();

    return view('frontend.programs', compact('data', 'programs'));
}

public function hostel_program()
{
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "Hostel Program - K. K. International School";
    $data['meta_keywords'] = "KK International School, Hostel Program, Residential Care, Dharan School";
    $data['meta_description'] = "Explore the Hostel Program at K. K. International School with safe care, supervised study, healthy routine and holistic development.";

    return view('frontend.hostel-program', compact('data'));
}

public function kkis_yearly_program()
{
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KKIS Yearly Program - K. K. International School";
    $data['meta_keywords'] = "KK International School, Yearly Programs, Academic Calendar, CCA, School Events";
    $data['meta_description'] = "Explore KKIS yearly programs, festivals, academic events and co-curricular activities for one academic session.";

    return view('frontend.kkis-yearly-program', compact('data'));
}

public function sop_of_kkis()
{
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "SOP of KKIS - K. K. International School";
    $data['meta_keywords'] = "KK International School, SOP, Daily Routine, Day Boarding, Hostel Routine";
    $data['meta_description'] = "View the standard operating procedure and daily routine of K. K. International School.";

    return view('frontend.sop-of-kkis', compact('data'));
}

public function admission_procedures()
{
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "Admission Procedures - K. K. International School";
    $data['meta_keywords'] = "KK International School, Admission Procedures, School Admission, Dharan School, KKIS Admission";
    $data['meta_description'] = "Learn about the admission procedures, age criteria, required documents and enrollment process at K. K. International School.";

    return view('frontend.registration', compact('data'));
}

   
public function term_conditions(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $term_condition = WebsiteData::where('type', 'Terms and Condition')
        ->where('status', 'Active')
        ->where('is_deleted', '0')
        ->get();

    return view('frontend.term_conditions', compact('data', 'term_condition'));
}

public function privacy_policy(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $privacy_policy = WebsiteData::where('type', 'Privacy Policy')
        ->where('status', 'Active')
        ->where('is_deleted', '0')
        ->get();

    return view('frontend.privacy_policy', compact('data', 'privacy_policy'));
}

public function cancellation_refund(){
    $data['menu'] = "";
    $data['sub_menu'] = "";
    $data['og_image'] = url('assets/frontend/assets/imgs/slider/school-banner.jpg');
    $data['meta_title'] = "KK International School - Best CBSE School for Quality Education";
    $data['meta_keywords'] = "KK International School, Best School, CBSE School, Top School in India, Quality Education, Modern School, Smart Classes, School Admission, English Medium School";
    $data['meta_description'] = "KK International School is committed to providing quality education with modern teaching methods, smart classrooms, and holistic development of students. We focus on academic excellence, discipline, and overall personality growth.";

    $cancellation_refund = WebsiteData::where('type', 'Cancellation & Refund')
        ->where('status', 'Active')
        ->where('is_deleted', '0')
        ->get();

    return view('frontend.cancellation_refund', compact('data', 'cancellation_refund'));
}



 public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname'  => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'number'    => 'required|string|max:255',
            'message'   => 'required|string|max:2000',
        ]);
 
       
        $id = DB::table('tbl_enquiry')->insertGetId([
            'name'       => $validated['firstname'] . ' ' . $validated['lastname'],
            'email'      => $validated['email'],
            'phone'      => $validated['number'],
            'message'    => $validated['message'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
        $data = [
            'id'        => $id,
            'name'      => $validated['firstname'] . ' ' . $validated['lastname'],
            'firstname' => $validated['firstname'],
            'email'     => $validated['email'],
            'phone'     => $validated['number'],
            'message'   => $validated['message'],
        ];
 
       
        Mail::to(config('school.admin_email'))->send(new EnquiryAdminMail($data));
 
       
        Mail::to($validated['email'])->send(new EnquiryCustomerMail($data));
 
        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your enquiry has been submitted successfully. We will contact you soon.',
        ]);
    }


}
