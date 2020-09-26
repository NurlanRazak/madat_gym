<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:1000px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs rating-nav">
            <li><a class="active show" data-toggle="tab" href="#ratingall">All</a></li>
            <li><a data-toggle="tab" href="#ratingweek">Week</a></li>
        </ul>

        <div class="tab-content">
            <div id="ratingall" class="tab-pane active">
                <div class="table-responsive">
                    <table class="table">
                      <tbody>
                          @foreach ($ratings as $raiting)
                              <tr>
                                  <td>
                                      {{ $loop->iteration }}
                                  </td>
                                  <td>
                                      {{ $raiting->user->name }}
                                  </td>
                                  <td>
                                      {{ ceil($raiting->rating) }}
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
            <div id="ratingweek" class="tab-pane">
                <div class="table-responsive">
                    <table class="table">
                      <tbody>
                          @foreach ($weekRatings as $raiting)
                              <tr>
                                  <td>
                                      {{ $loop->iteration }}
                                  </td>
                                  <td>
                                      {{ $raiting->user->name }}
                                  </td>
                                  <td>
                                      {{ ceil($raiting->rating) }}
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
