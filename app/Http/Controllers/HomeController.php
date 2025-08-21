<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\MatchResult;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with latest news and upcoming fixtures.
     */
    public function index()
    {
        // Get latest 3 featured news articles
        $featuredNews = News::published()
            ->featured()
            ->latest()
            ->limit(3)
            ->get();

        // Get latest 6 news articles for news section
        $latestNews = News::published()
            ->latest()
            ->limit(6)
            ->get();

        // Get the most recent completed match (Previous Match)
        $previousMatch = Fixture::with(['tournament', 'homeTeam', 'awayTeam'])
            ->where('match_date', '<', now())
            ->where('status', 'completed')
            ->orderBy('match_date', 'desc')
            ->first();

        // Get the next upcoming fixture (Next Fixture)
        $nextFixture = Fixture::with(['tournament', 'homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->first();

        // Get upcoming fixtures after the next one (Upcoming Fixtures)
        $upcomingFixtures = Fixture::with(['tournament', 'homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->skip(1)
            ->limit(1)
            ->get();

        // Get all fixtures for the fixtures-two section (next + upcoming, limited to 8)
        $allFixtures = Fixture::with(['tournament', 'homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->limit(8)
            ->get();

        // Get recent 3 match results for other sections if needed
        $recentMatches = MatchResult::recent(3)->get();

        // Get senior team players grouped by position for squad tabs
        $seniorPlayers = Player::active()
            ->senior()
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return view('welcome', compact(
            'featuredNews',
            'latestNews', 
            'previousMatch',
            'nextFixture',
            'upcomingFixtures',
            'allFixtures',
            'recentMatches',
            'seniorPlayers'
        ))->with('news', $latestNews);
    }

    /**
     * Display all news articles.
     */
    public function news()
    {
        // Determine which view to return based on the current route
        $routeName = request()->route()->getName();
        
        // Map route names to category slugs
        $categoryMapping = [
            'latestnews' => 'latest-news',
            'newsupdates' => 'updates',
            'breakingnews' => 'breaking-news'
        ];
        
        // Filter news by category if route has a specific category mapping
        $newsQuery = News::published()->latest();
        
        if (isset($categoryMapping[$routeName])) {
            $newsQuery->whereHas('category', function($query) use ($categoryMapping, $routeName) {
                $query->where('slug', $categoryMapping[$routeName]);
            });
        }
        
        $news = $newsQuery->paginate(12);
        
        switch ($routeName) {
            case 'latestnews':
                return view('pages.latestnews', compact('news'));
            case 'newsupdates':
                return view('pages.newsupdates', compact('news'));
            case 'breakingnews':
                return view('pages.breakingnews', compact('news'));
            default:
                return view('pages.news', compact('news'));
        }
    }

    /**
     * Display a single news article.
     */
    public function showNews($slug)
    {
        $article = News::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Get related news from the same category first
        $relatedNews = News::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest()
            ->limit(4)
            ->get();

        // If we don't have enough related news from the same category, fill with recent news
        if ($relatedNews->count() < 4) {
            $additionalNews = News::published()
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->latest()
                ->limit(4 - $relatedNews->count())
                ->get();
            
            $relatedNews = $relatedNews->merge($additionalNews);
        }

        return view('posts.viewpost', compact('article', 'relatedNews'));
    }

    /**
     * Display all players.
     */
    public function players()
    {
        $players = Player::active()
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        // Determine which view to return based on the current route
        $routeName = request()->route()->getName();
        
        switch ($routeName) {
            case 'viewplayer':
                return view('playerprofile.viewplayer', compact('players'));
            default:
                return view('pages.players', compact('players'));
        }
    }

    /**
     * Display a single player profile.
     */
    public function showPlayer($id)
    {
        $player = Player::active()->findOrFail($id);
        
        // Get related players from same team category and position
        $relatedPlayers = Player::active()
            ->where('id', '!=', $player->id)
            ->where('team_category', $player->team_category)
            ->where('position', $player->position)
            ->limit(6)
            ->get();
        
        // If not enough players from same position, get from same team category
        if ($relatedPlayers->count() < 3) {
            $relatedPlayers = Player::active()
                ->where('id', '!=', $player->id)
                ->where('team_category', $player->team_category)
                ->limit(6)
                ->get();
        }
        
        return view('playerprofile.viewplayer', compact('player', 'relatedPlayers'));
    }

    /**
     * Display senior team players.
     */
    public function seniorTeam()
    {
        $players = Player::active()
            ->where('team_category', 'senior')
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return view('pages.team', compact('players'));
    }

    /**
     * Display U20 academy team players.
     */
    public function u20Team()
    {
        $players = Player::active()
            ->where('team_category', 'u20')
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return view('pages.u20team', compact('players'));
    }

    /**
     * Display U17 academy team players.
     */
    public function u17Team()
    {
        $players = Player::active()
            ->where('team_category', 'u17')
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return view('pages.u17team', compact('players'));
    }

    /**
     * Display U15 academy team players.
     */
    public function u15Team()
    {
        $players = Player::active()
            ->where('team_category', 'u15')
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return view('pages.u15team', compact('players'));
    }

    /**
     * Display U13 academy team players.
     */
    public function u13Team()
    {
        $players = Player::active()
            ->where('team_category', 'u13')
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return view('pages.u13team', compact('players'));
    }

    /**
     * Display fixtures and upcoming matches.
     */
    public function fixtures()
    {
        $upcomingFixtures = Fixture::with(['tournament', 'matchEvents', 'homeTeam', 'awayTeam'])
            ->upcoming()
            ->orderBy('match_date', 'asc')
            ->paginate(15);

        $featuredFixtures = Fixture::with(['tournament', 'matchEvents', 'homeTeam', 'awayTeam'])
            ->featured()
            ->upcoming()
            ->orderBy('match_date', 'asc')
            ->take(3)
            ->get();

        $recentResults = Fixture::with(['tournament', 'matchEvents', 'homeTeam', 'awayTeam'])
            ->withResults()
            ->orderBy('match_date', 'desc')
            ->take(5)
            ->get();

        return view('pages.fixtures', compact('upcomingFixtures', 'featuredFixtures', 'recentResults'));
    }

    /**
     * Display match results.
     */
    public function results()
    {
        $results = MatchResult::orderBy('match_date', 'desc')
            ->paginate(10);

        return view('pages.results', compact('results'));
    }

    /**
     * Display league tables.
     */
    public function tables()
    {
        // For now, return static view - can be enhanced later with actual league data
        return view('pages.tables');
    }

    /**
     * Display about page.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display mission and vision page.
     */
    public function missionVision()
    {
        return view('about.missionvision');
    }

    /**
     * Display club history page.
     */
    public function history()
    {
        return view('about.history');
    }

    /**
     * Display AZAM FC TV page.
     */
    public function tv()
    {
        return view('pages.tv');
    }

    /**
     * Display a specific fixture.
     */
    public function showFixture(Fixture $fixture)
    {
        $fixture->load(['tournament', 'homeTeam', 'awayTeam', 'matchEvents']);
        
        return view('pages.fixture', compact('fixture'));
    }
}