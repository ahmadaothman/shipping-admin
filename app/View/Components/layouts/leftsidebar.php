<?php

namespace App\View\Components\layouts;

use Illuminate\View\Component;
use App\Models\UserType;

class leftsidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user_types = UserType::where('range',2)
        ->orderBy('id')
        ->get();

        
        $data = array();
        $data['user_types'] = $user_types;
        return view('components.layouts.leftsidebar',$data);
    }
}
