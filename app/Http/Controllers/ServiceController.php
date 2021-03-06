<?php namespace App\Http\Controllers;

use App\Http\Requests\ServiceCreateRequest;

use App\Repositories\ServiceRepository;
use Auth;
use App\User;
use App\Salon;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceRepository;

    protected $nbrPerPage = 10;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->middleware('auth',['except' => 'show']);
        $this->middleware('owner', ['except' => 'show']);
        $this->middleware('confirmed', ['except' => 'show']);
        $this->middleware('chose_salon', ['except' => 'show']);

        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $services = Salon::find(session('salon_chosen'))->services;
        return view('salon_configuration/services/index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $salon_id=session('salon_chosen');
        return view('salon_configuration/services/create')->with(['salon_id' => $salon_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ServiceCreateRequest $request)
    {
        $inputs = $request->all();
        if ($inputs['duration'] % 15 == 0 AND $inputs['duration'] > 0) {
            $service = $this->serviceRepository->store($inputs);
            return redirect('/service');
        }
        return redirect()->back()->withErrors(['duration' => 'The duration must be a multiple of 15 minutes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $service = $this->serviceRepository->getById($id);

        return view('salon_configuration/services/show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->getById($id);
        if ($service->salon_id == session('salon_chosen')) {
            return view('salon_configuration/services/edit', compact('service'));
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(ServiceCreateRequest $request, $id)
    {
        $inputs = $request->all();
        if ($inputs['duration'] % 15 == 0 AND $inputs['duration'] > 0) {
            $this->serviceRepository->update($id, $inputs);
            return redirect('/service');
        }
        return redirect()->back()->withErrors(['duration' => 'The duration must be a multiple of 15 minutes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $service=$this->serviceRepository->getById($id);
        if ($service->salon_id == session('salon_chosen')) {
            $this->serviceRepository->destroy($id);
        }
        return redirect()->back();
    }

}

?>