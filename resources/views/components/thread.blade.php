@foreach($comments as $comment)
    <li class="uk-margin-remove">
        <article class="uk-comment"　id="{{ $comment->id }}">
            <header class="uk-comment-header uk-margin-remove">
                <div class="uk-grid-collapse" uk-grid>

                    <!-- Profile Image -->
                    <div class="uk-width-auto">
                        <img class="uk-comment-avatar uk-border-circle" src="{{ $comment->user->profile->profileImage() }}" width="50" height="50" alt="">
                    </div>       

                    <div class="uk-width-expand uk-padding-small uk-padding-remove-top">
                        <div class="uk-flex uk-flex-right">
                            <!-- Username -->
                            <div class="uk-width-expand uk-text-truncate">
                                <a class="uk-link-reset uk-text-bold" href="/profile/{{ $comment->user->username }}">{{ $comment->user->username }}</a>
                            </div>

                            <!-- More icon -->
                            @if(auth()->user()->id == $comment->user_id && !$comment->deleted_at)
                                <div>
                                    <a class="uk-link-reset" href="#" uk-icon="icon: more"></a>
                                    <div id="dropNav" uk-dropdown="pos: bottom-right; mode: click">
                                        <ul class="uk-nav uk-dropdown-nav">
                                            <form id="{{ 'deleteComment' .  $comment->id }}" action="{{  LaravelLocalization::LocalizeURL(route('comment.destroy', ['post' => $comment->post_id, 'comment' => $comment->id])) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <!-- Edit -->
                                                <li><a class="uk-link-muted uk-margin-bottom" href="/p/{{ $comment->post_id }}/comment/{{ $comment->id }}/edit">{{ __('Edit') }}</a></li>

                                                <!-- Delete (an anchor toggiling the modal)-->
                                                <li><a href="#deleteCommentModal{{ $comment->id }}" class="uk-link-muted" uk-toggle>{{ __('Delete') }}</a></li>
                                                <!-- The modal -->
                                                <div id="deleteCommentModal{{ $comment->id }}" uk-modal="container: false;">
                                                    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical ">
                                                        <p class="uk-text-default">{{ __('Do you really want to delete the seleceted comment? This process cannot be undone.') }}</p>
                                                        <p class="uk-text-right">
                                                            <button class="uk-button uk-button-default uk-text-bold uk-modal-close" type="button">{{ __('No') }}</button>
                                                            <button class="uk-button uk-button-primary uk-text-bold" type="submit">{{ __('Yes') }}</button>
                                                        </p>
                                                    </div>
                                                </div>

                                            </form>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="uk-invisible">
                                    <a uk-icon="icon: more"></a>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Comment -->
                        @if($comment->deleted_at)  
                            <p class="uk-text-muted uk-text-break uk-margin-small">{{ __('This comment has been deleted.') }}</p>
                        @else
                            <p class="new-line uk-text-break uk-margin-small">{{ $comment->comment}}</p>
                        @endif

                        <!-- Reply -->
                        @if(!$comment->deleted_at)
                            <div class="uk-flex uk-flex-right">
                                <div class="uk-width-expand"></div>
                                <div>
                                    <a class="uk-link-muted" href="/p/{{ $comment->post_id }}/comment/{{ $comment->id }}/create"><i class="fas fa-reply"></i></a>
                                </div>
                            </div>
                        @endif            
                    </div>
                </div> 
            </header>
        </article>
    </li>
    @include('components.thread', ['comments' => $comment->replies])
@endforeach