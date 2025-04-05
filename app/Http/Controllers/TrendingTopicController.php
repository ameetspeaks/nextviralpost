<?php

namespace App\Http\Controllers;

use App\Models\TrendingTopic;
use Illuminate\Http\Request;

class TrendingTopicController extends Controller
{
    public function index()
    {
        $trendingTopics = TrendingTopic::orderBy('trend_score', 'desc')
            ->paginate(12);

        return view('trending-topics.index', compact('trendingTopics'));
    }

    public function show(TrendingTopic $trendingTopic)
    {
        return view('trending-topics.show', compact('trendingTopic'));
    }
} 