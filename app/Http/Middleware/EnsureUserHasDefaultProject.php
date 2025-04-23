<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasDefaultProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && ! $user->default_project) {
            session()->flash('blink_component', true);
            return redirect()->route('projects')
                ->with('error', 'Please select or create a project first.');
        }

        $is_project_exists = Project::where('id', $user->default_project)
            ->where('is_archived', 'false')
            ->exists();

        if (! $is_project_exists) {
            $user->default_project = null;
            $user->save();

            session()->flash('blink_component', true);
            return redirect()->route('projects')
                ->with('warning', 'Please select or create a project first.');
        }
        return $next($request);
    }
}
