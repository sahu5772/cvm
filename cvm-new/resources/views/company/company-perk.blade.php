@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Company Perk</div>
        <div class="row">
          <div class="col-4">
            <form action="{{ route('company-perk.store') }}" method="POST">
                @csrf
              <div class="add__option">
                <div class="input_grp">
                  <label for="">Company Perks</label>
                  <input type="text" placeholder="type here..." name="name"/>
                </div>
              </div>
              <!-- ./add__option -->
              <div class="button_flex">
                <button type="submit" class="btn_style">Save</button>
                <button type="reset" class="btn_style ghost_btn">Cancel</button>
              </div>
            </form>
          </div>

          <div class="col-8">
            <div class="table__wrapper">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" width="18%">Sr No.</th>
                    <th scope="col">Company Perks</th>
                    <th scope="col">Action</th>
                    <th scope="col" width="10%"></th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($data as $k => $value)
                    <tr>
                        <th scope="row">{{ $k+1}}</th>
                        <td>{{ $value->name }}</td>
                        <td>
                            <form action="{{ route('company-perk.destroy', $value->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="2">no record found</td>
                      </tr>
                      @endforelse
                </tbody>
              </table>
            </div>
            <!-- ./table__wrapper -->
          </div>
        </div>
        <!-- ./row -->
    </section>
</main>
    
@endsection

