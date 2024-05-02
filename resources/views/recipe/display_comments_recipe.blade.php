<div class="col-md-8 col-lg-6">
    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
      <div class="card-body p-4">
        @forelse ($comments as $comment)
        <div class="card mb-4">
            <div class="card-body">
                <p>{{$comment['comment']}}</p>
                <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center">
                    <img src="@if ($comment['picture'] != null)
                                        {{asset("assets/img/user/".$comment['picture'])}}
                                    @else
                                        {{ asset('assets/img/login_logo.png') }}
                                    @endif" alt="avatar" style="width: auto; height: 40px; clip-path:circle();"/>
                    <p class="small mb-0 ms-2">{{$comment['first_name']}}</p>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <?php
                        for ($i=0; $i < $comment['mark']; $i++) {
                            ?><i class="hover">&#9733;</i><?php
                        }
                    ?>
                </div>
                </div>
            </div>
        </div>
        @empty
            <div class="d-flex justify-content-center">
            <p>Aucun commentaire.</p>
            </div>
        @endforelse
      <div class="row mb-3">
          {{ $comments->onEachSide(1)->links() }}
      </div>
    </div>
</div>
