@extends("layout")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-body text-center">
                <h5 class="card-title">Are you sure to remove this?</h5>
                <form action="" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{ url()->previous() }}">No</a>
                    <button type="submit" class="btn btn-danger mr-2">Yes, remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection