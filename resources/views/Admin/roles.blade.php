@extends('admin.layout.master')
@section('content')
<style>
.float-right{
    float:right;
    position:sticky;
}
}

</style>
<div id="wrapper">
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
                        <h3 class="panel-title">Roles</h3>
                        <form action="/add-roles" method="POST" enctype="multipart/form-data" class="justify-content-center">
                        @csrf
                        <div class="form-row">
                        <div class="form-group col-md-6">
                        <input type="text" id="name" name="role_name" class="form-control" placeholder="Name">
                        <span class="text-danger">@error('role_name') {{$message}}  @enderror</span>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Roles</button>
                        </form>
						</div>
						<div class="panel-body">
							<div class="row">

							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<!-- <h3 class="panel-title">Basic Table</h3> -->
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>ID</th>
												<th>Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($items as $item)
											<tr>
												<td>{{$item->id}}</td>
												<td>{{$item->role_name}}</td>
												<td><a href="{{'delete_video/' .$item->id }}" onclick="return confirm('Are you sure you want to delete this Roles?');" class="">                   
                                                <img src="https://img.icons8.com/wired/30/000000/delete-forever.png"/></a></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<!-- END BASIC TABLE -->
							</div>
							<!-- END REALTIME CHART -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		</div>
		@endsection