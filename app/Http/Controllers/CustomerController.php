<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Customer;
use App\Point;
use App\Referral;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.login');
    }

    public function register()
    {
        return view('customers.register');
    }
    public function checkUser(Request $request)
    {
        echo "hello world";
    }
    public function saveUser(Request $request)
    {
        // $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'    => 'required|email',
            'password'          => 'required|min:4|max:10',
            'password-confirm'   => 'required|same:password',
        ]);
        // if there are errors
        if ($validator->fails()) {
            return redirect::back()
                ->withErrors($validator, 'registerErrors')
                ->withInput();
        } else {

            if ($request->referral) {

                $referral = Referral::where('code', $request->referral)->first();
                // print_r($referral->count);
                // exit();
                if ($referral) {
                    $customer = new Customer;
                    $customer->name = $request->name;
                    $customer->email = $request->email;
                    $customer->password = Hash::make($request->password);;
                    $customer->used_referral = $request->referral;
                    // create new referal code for new user
                    $newReferral = new Referral;

                    $lastreferral = Customer::orderBy('created_at', 'DESC')->first();
                    if (isset($lastreferral)) {
                        $newReferral->code = str_pad($lastreferral->id + 1, 11, "referral", STR_PAD_LEFT);
                    } else {
                        $newReferral->code = 'referralre1';
                    }
                    $customer->referral_code = $newReferral->code;

                    if ($customer->save()) {

                        $counter = $referral->count + 1;
                        Referral::where('code', $request->referral)
                            ->update(['count' => $counter]);
                        if ($counter <= 10) {
                            if ($counter == 1) {
                                // $point = Point::where('user_id', $referral->user_id)->first();
                                // if ($point) {
                                //     $totalPoint = $ponit->points + 10;
                                //     Point::where('code', $request->referral)
                                //         ->update(['count' => $counter]);
                                // } else {
                                    $ponits = new Point;
                                    $ponits->user_id = $referral->user_id;
                                    $ponits->points = $ponits->points + 10;
                                    $ponits->save();
                                // }
                            } elseif ($counter == 2) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->points + 9;
                                    Point::where('user_id', $referral->user_id)
                                        ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 3) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 8;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 4) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 7;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 5) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 6;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 6) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 5;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 7) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 4;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 8) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 3;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 9) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 2;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            } elseif ($counter == 10) {
                                $point = Point::where('user_id', $referral->user_id)->first();
                                if ($point) {
                                    $totalPoint = $point->point + 1;
                                    Point::where('user_id', $referral->user_id)
                                    ->update(['points' => $totalPoint]);
                                }
                            }
                        }
                        return view('customers.success');
                    } else {
                        return view('customers.failed');
                    }
                } else {
                }
            } else {
                $customer = new Customer;
                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->password = Hash::make($request->password);
                // $customer->used_referral = $request->referral;
                // create new referal code for new user
                $newReferral = new Referral;
                // $newReferral->user_id = Auth()->id();
                $lastreferral = Customer::orderBy('created_at', 'DESC')->first();
                if (isset($lastreferral)) {
                    $newReferral->code = str_pad($lastreferral->id + 1, 11, "referral", STR_PAD_LEFT);
                } else {
                    $newReferral->code = 'referralre1';
                }
                // $newReferral->save();
                $customer->referral_code = $newReferral->code;

                if ($customer->save()) {
                    $lastreferral = Customer::orderBy('created_at', 'DESC')->first();
                    // print_r($lastreferral['id']);
                    // exit();
                    $newReferral->user_id = $lastreferral['id'];
                    $newReferral->save();
                    return view('customers.success');
                } else {
                    return view('customers.failed');
                }
            }
        }
    }
}
