<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getHomePage() {
        return view('home');
    }


    public function getTermsOfServicePage() {
        return view('terms_of_service');
    }


    public function getPrivacyPolicyPage() {
        return view('privacy_policy');
    }


    public function getRedirectToBuyLinkPage(Request $request) {
        $buyLink = $request->query('url');

        return view('redirect_to_buy_link', compact('buyLink'));
    }
}
