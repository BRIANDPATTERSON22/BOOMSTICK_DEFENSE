<?php namespace App\Http\Controllers\Site;

use Carbon\Carbon;
use App\Page;
use App\Room;
use App\Testimonial;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    public function __construct(Page $page, Testimonial $testimonial, Room $room)
    {
        $this->page = $page;
        $this->testimonial = $testimonial;
        $this->room = $room;

        $this->option = Cache::get('optionCache');
        $this->theme = Cache::get('themeCache');
        $this->middleware('guest');
    }

    public function get_all()
    {
        $todayDate = Carbon::today(); $today = $todayDate->format('Y-m-d');
        $page = $this->page->where('slug', 'like', '%'.'testimonial'.'%')->where('status', 1)->first();

        if($page){
            $allData = $this->testimonial->where('status', 1)->orderBy('id', 'DESC')->paginate(15);

            $ourRooms = $this->room->select('room.*', 'room_price.date_from','room_price.date_to','room_price.mon','room_price.tue','room_price.wed','room_price.thu','room_price.fri','room_price.sat','room_price.sun')
                ->join('room_price', 'room.id', '=', 'room_price.room_id')
                ->where('room.hotel_id', $this->option->hotel_id)
                ->groupBy('room.id')->orderBy('room.price', 'ASC')->get();

            return view('site.'.$this->theme.'.testimonial.index', compact('page', 'allData', 'ourRooms', 'today'));
        }
        else{
            return view('site.'.$this->theme.'.errors.404');
        }
    }

    public function get_single($slug)
    {
        $todayDate = Carbon::today(); $today = $todayDate->format('Y-m-d');

        $page = $this->page->where('slug', 'like', '%'.'testimonial'.'%')->where('status', 1)->first();
        $data = $this->testimonial->where('slug', $slug)->first();

        if($page && $data) {
            $singleData = $this->testimonial->find($data->id);
            $otherData = $this->testimonial->where('id', '!=', $data->id)->where('status', 1)->limit(5)->get();

            $ourRooms = $this->room->select('room.*', 'room_price.date_from','room_price.date_to','room_price.mon','room_price.tue','room_price.wed','room_price.thu','room_price.fri','room_price.sat','room_price.sun')
                ->join('room_price', 'room.id', '=', 'room_price.room_id')
                ->where('room.hotel_id', $this->option->hotel_id)
                ->groupBy('room.id')->orderBy('room.price', 'ASC')->get();

            return view('site.'.$this->theme.'.testimonial.single', compact('page', 'singleData', 'otherData', 'ourRooms', 'today'));
        }
        else{
            return view('site.'.$this->theme.'.errors.404');
        }
    }
}