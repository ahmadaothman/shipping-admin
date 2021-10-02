<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add default branch
        DB::table('branch')->insert([
            'id'        =>  1,
            'name'      =>  'Main Branch',
            'country'   =>  'LB',
            'city'      =>  'Tripoli',
            'telephone' =>  '000 000 000'
        ]);
        

        for($i =2;$i<=80;$i++){
            DB::table('branch')->insert([
                'name'      =>  'Test Branch' . $i,
                'country'   =>  'LB',
                'city'      =>  'Tripoli',
                'telephone' =>  '000 000 000' . $i
            ]);    
        }
        // add super admin user
        DB::table('users')->insert([
            'name'          => 'Super Admin',
            'email'         => 'admin@site.com',
            'telephone'     => '000 000 000',
            'user_type_id'  =>  1,
            'branch_id'     =>  1,
            'status'        => true,
            'password'      => Hash::make('admin@1234'),
        ]);
        // add user types
        $user_types = array([
            'id'        => 1, 
            'name'      => 'Super Admin',
            'range'     => 1,
            'user_icon' =>  '<i class="icon-copy fa fa-certificate" aria-hidden="true"></i>'
        ],
        [
            'id'        => 2, 
            'name'      => 'Data Entry',
            'range'     => 1,
            'user_icon' =>  '<i class="icon-copy fa fa-keyboard-o" aria-hidden="true"></i>'

        ],
        [
            'id'        => 3, 
            'name'      => 'Admin',
            'range'     => 2,
            'user_icon' =>  '<i class="icon-copy fa fa-user-circle-o" aria-hidden="true"></i>'
        ],
        [
            'id'        => 4, 
            'name'      => 'Data Entry',
            'range'     => 2,
            'user_icon' =>  '<i class="icon-copy fa fa-keyboard-o" aria-hidden="true"></i>'
        ]
        ,
        [
            'id'    => 5,
            'name' => 'Ware House',
            'range' => 2,
            'user_icon' =>  '<i class="icon-copy fa fa-archive" aria-hidden="true"></i>'

        ],
        [
            'id'        => 6,
            'name'      => 'Accounting',
            'range'     => 2,
            'user_icon' =>  '<i class="icon-copy fa fa-money" aria-hidden="true"></i>'
        ],
        [
            'id'        => 7,
            'name'      => 'Driver',
            'range'     => 2,
            'user_icon' =>  '<i class="icon-copy fa fa-motorcycle" aria-hidden="true"></i>'
        ]);

        foreach($user_types as $type){
            DB::table('user_type')->insert($type);
        }
        // add status group
        $status_group = array(
            [
                'id'            =>  1,
                'name'          =>  'New',
                'sort_order'    =>  0,
                'color'         =>  'bg-success',
                'logo'          =>  '<i class="icon-copy fa fa-hourglass" aria-hidden="true"></i>',
            ],
            [
                'id'            =>  2,
                'name'          =>  'Live',
                'sort_order'    =>  1,
                'color'         =>  'bg-warning',
                'logo'          =>  '<i class="icon-copy fa fa-truck" aria-hidden="true"></i>'
            ],
            [
                'id'            =>  3,
                'name'          =>  'Completed',
                'sort_order'    =>  2,
                'color'         =>  'bg-info',
                'logo'          =>  '<i class="icon-copy fa fa-check" aria-hidden="true"></i>'
            ],
            [
                'id'            =>  4,
                'name'          =>  'Paid',
                'sort_order'    =>  3,
                'color'         =>  'bg-primary',
                'logo'          =>  '<i class="icon-copy fa fa-money" aria-hidden="true"></i>'
            ],
            [
                'id'            =>  5,
                'name'          =>  'Unsuccessful',
                'sort_order'    =>  4,
                'color'         =>  'bg-danger',
                'logo'          =>  '<i class="icon-copy fa fa-thumbs-down" aria-hidden="true"></i>',
            ],
            [
                'id'            =>  6,
                'name'          =>  'Returned',
                'sort_order'    =>  5,
                'color'         =>  'bg-muted',
                'logo'          =>  '<i class="icon-copy fa fa-undo" aria-hidden="true"></i>'
            ],
            [
                'id'            =>  7,
                'name'          =>  'Canceled',
                'sort_order'    =>  6,
                'color'         =>  'bg-dark',
                'logo'          =>  '<i class="icon-copy fa fa-close" aria-hidden="true"></i>'
            ],
        );

        foreach($status_group as $group){
            DB::table('shipment_status_group')->insert($group);
        }
        // add status
        $shipment_status = array([

            // NEW
            [
                'name'                      =>  'Created By System',
                'shipment_status_group_id'  =>  1,
                'sort_order'                =>  0
            ],
            [
                'name'                      =>  'Created By Agent Portal',
                'shipment_status_group_id'  =>  1,
                'sort_order'                =>  1
            ],
            [
                'name'                      =>  'Created By Agent API',
                'shipment_status_group_id'  =>  1,
                'sort_order'                =>  2
            ],
            [
                'name'                      =>  'Created By Agent Excel',
                'shipment_status_group_id'  =>  1,
                'sort_order'                =>  3
            ],
            // LIVE
            [
                'name'                      =>  'Picked Up From The Shipper',
                'shipment_status_group_id'  =>  2,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Arrived At The Branch',
                'shipment_status_group_id'  =>  2,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Sent To The Main Branch',
                'shipment_status_group_id'  =>  2,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Sorted By Region',
                'shipment_status_group_id'  =>  2,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Out For Delivery',
                'shipment_status_group_id'  =>  2,
                'sort_order'                =>  4
            ],
            // Unsuccessful
            [
                'name'                      =>  'Postponed',
                'shipment_status_group_id'  =>  5,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'No Answer',
                'shipment_status_group_id'  =>  5,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Rejected',
                'shipment_status_group_id'  =>  5,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Faild Collected',
                'shipment_status_group_id'  =>  5,
                'sort_order'                =>  4
            ],
            // Canceled
            [
                'name'                      =>  'Canceled From Agent Side (Portal)',
                'shipment_status_group_id'  =>  7,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Canceled From Agent Side (Api)',
                'shipment_status_group_id'  =>  7,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Canceled By System',
                'shipment_status_group_id'  =>  7,
                'sort_order'                =>  4
            ],
            
            // Completed
            [
                'name'                      =>  'Completed',
                'shipment_status_group_id'  =>  3,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Complete Collected',
                'shipment_status_group_id'  =>  3,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Awaiting To Paid',
                'shipment_status_group_id'  =>  3,
                'sort_order'                =>  4
            ],
            // PAID
            [
                'name'                      =>  'Paid At Branch',
                'shipment_status_group_id'  =>  4,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Paid At Agent Location',
                'shipment_status_group_id'  =>  4,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Paid As Bank Payment',
                'shipment_status_group_id'  =>  4,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Paid As A Cheque',
                'shipment_status_group_id'  =>  4,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Paid As A Local Transfer',
                'shipment_status_group_id'  =>  4,
                'sort_order'                =>  4
            ],
            // Returned
            [
                'name'                      =>  'Out To Return',
                'shipment_status_group_id'  =>  6,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Returned To Agent Location',
                'shipment_status_group_id'  =>  6,
                'sort_order'                =>  4
            ],
            [
                'name'                      =>  'Collected By Agent From The Branch',
                'shipment_status_group_id'  =>  6,
                'sort_order'                =>  4
            ],
        ]);

        foreach($shipment_status as $status){
            DB::table('shipment_status')->insert($status);
        }

        // add facke agents
        for($i =0;$i<=80;$i++){
            DB::table('agent')->insert([
                'name'          =>  'Agent ' . $i,
                'telephone'     =>  $i . '012345678',
                'email'         =>  'email' . $i . '@site.com',
                'password'      =>  Hash::make($i . 'password@1234'),
                'website'       =>  'https://www.site' . $i . '.com',
                'country'       =>  'LB',
                'address'       =>  'Agent address ' . $i,
                'logo'          =>  '',
                'status'        =>  1,
                'sort_order'    =>  $i,
                'group_id'      => 0,

            ]);
        }
        // add service types
        $service_type = array([
            [
                'id'            =>  1,
                'name'          =>  'Normal Shipment',
                'default'       =>  true,
                'sort_order'    => 0
            ],
            [
                'id'            =>  2,
                'name'          =>  'Reverse Shipment',
                'default'       =>  false,
                'sort_order'    => 1
            ],
            [
                'id'            =>  3,
                'name'          =>  'Exchange Shipment',
                'default'       =>  false,
                'sort_order'    => 2
            ],
        ]);

        foreach($service_type as $type){
            DB::table('service_type')->insert($type);
        }
        // add currencies
        $currencies = array([
            [
                'id'                =>      1,
                'title'             =>      'Lebanese Pound',
                'code'              =>      'LBP',
                'left_symbole'      =>      '',
                'right_symbole'     =>      'L.L',
                'default'           =>      true,
                'decimal_number'    =>      0,
                'sort_order'        =>      0
            ],
            [
                'id'                =>      2,
                'title'             =>      'United State Dollar',
                'code'              =>      'USD',
                'left_symbole'      =>      '$',
                'right_symbole'     =>      '',
                'default'           =>      false,
                'decimal_number'    =>      2,
                'sort_order'        =>      0
            ]
        ]);

        foreach($currencies as $currency){
            DB::table('currency')->insert($currency);
        }

        // payment mathods
        $payment_methods = array([
            [
                'id'        =>  1,
                'name'      =>  'Cash On Delivey',
                'default'   =>  true,
            ],
            [
                'id'        =>  2,
                'name'      =>  'Paid',
                'default'   =>  false,
            ],
            [
                'id'        =>  3,
                'name'      =>  'Credit Card On Delivery',
                'default'   =>  false,
            ],
            [
                'id'        =>  4,
                'name'      =>  'Cheque',
                'default'   =>  false,
            ],
        ]);

        foreach($payment_methods as $data){
            DB::table('payment_method')->insert($data);
        }

        $settings = [
            [
                'company_id'    =>  0,
                'setting'       =>  'shipping_cost',
                'value'         =>  20000
            ]
        ];

        foreach($settings as $data){
            DB::table('setting')->insert($data);
        }
    }
}
