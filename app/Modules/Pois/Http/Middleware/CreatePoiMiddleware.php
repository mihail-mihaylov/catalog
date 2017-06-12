<?php

namespace App\Modules\Pois\Http\Middleware;

use Closure;

class CreatePoiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $request->input('coordinates');
        // $request->input('name');
        // $this->validateIcon($request->input('icon'));
        // $this->validatePoiShape($request->input('poi_shape'));

        // if ($request->input('age') <= 200) {
        //     return redirect('home');
        // }
        return $next($request);
    }

    public function validateName($name)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validateIcon($icon)
    {
        if (strcmp($icon, 'house_parking') == 0 ||
            strcmp($icon, 'store') == 0 ||
            strcmp($icon, 'shop') == 0 ||
            strcmp($icon, 'factory') == 0 ||
            strcmp($icon, 'office') == 0 ||
            strcmp($icon, 'service') == 0 ||
            strcmp($icon, 'gasstation') == 0
        ) {
            return $icon;
        } else {
            return "Something went wrong with the Icon";
        }
    }

    public function validatePoiShape($shape)
    {
        if (strcmp($shape, 'polygon') == 0 ||
            strcmp($shape, 'polyline') == 0 ||
            strcmp($shape, 'marker') == 0 ||
            strcmp($shape, 'circle') == 0 ||
            strcmp($shape, 'rectangle') == 0
        ) {
            return $shape;
        } else {
            return "Something went wrong with the Poi Type";
        }
    }

    public function validateCoordinates()
    {

    }
}
