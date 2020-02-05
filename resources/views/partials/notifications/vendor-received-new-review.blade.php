<tr class="signupnotif">
    <td>
        @if (!$notification->read_at)
            @include('partials.unread-notification-indicator')
        @endif
        {{ $notification->created_at->diffForHumans()}}
    </td>
    <td>
        <div class="name">
            <strong>{{ $notification->data['title'] ?? '--' }}</strong>
        </div>
        <div class="desc">
            {!! $notification->data['body'] ?? '--' !!}
        </div>
    </td>
    <td>
        <a href="#"
            data-notificationid="{{ $notification->id }}"
            data-toggle="modal"
            data-target="#request-vendor-review"
            class="btn wb-btn-orange view-new-review">
            View Review
        </a>
    </td>
</tr>
<!-- Onboarding Modal -->
<div class="modal fade" id="request-vendor-review" role="dialog">
    <div id="wb-modal-vendor4b" class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="row mt20">
                        <form class="form-inline">
                            <br/>
                            <p>Event Type</p>
                            <div class="form-group">
                                {{ $notification->data['review']['event_type'] }}
                            </div>
                            <br/>
                            <p>Event Date</p>
                            <div class="form-group">
                                {{ $notification->data['review']['event_date'] }}
                            </div>
                            <br/>
                            <p>Ease to work with</p>
                            <div class="rating" id="easy_to_work_with">
                                @php
                                    $asize = $notification->data["review"]["rating_breakdown"]["easy_to_work_with"];
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    <a class='star @if ($i <= $asize - 1) selected @endif'><i class="fa fa-star"></i></a>
                                @endfor
                            </div>
                            <br/>
                            <p>Likelihood of recommending your business</p>
                            <div class="rating" id="likely_to_recoment_to_a_friend">
                                @php
                                    $bsize = $notification->data["review"]["rating_breakdown"]["likely_to_recoment_to_a_friend"];
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    <a class='star @if ($i <= $bsize - 1) selected @endif'><i class="fa fa-star"></i></a>
                                @endfor
                            </div>
                            <br/>
                            <p>Overall Satisfaction</p>
                            <div class="rating" id="overall_satisfaction">
                                @php
                                    $csize = $notification->data["review"]["rating_breakdown"]["overall_satisfaction"];
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    <a class='star @if ($i <= $csize - 1) selected @endif'><i class="fa fa-star"></i></a>
                                @endfor
                            </div>
                            <br/>
                            <p>Additional comments from the Couple</p>
                            <div class="form-group">
                                <i>{{ $notification->data["review"]['message'] }}</i>
                            </div>
                        </form>
                    </div>
                    <div class="actions">
                        <br/><br/>
                        <a href="#" data-dismiss="modal"
                            class="btn-fixed-1-2 step2 wb-btn wb-btn-lg wb-btn-gray back">
                            Close
                        </a>
                        <br/><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.view-new-review').on('click', function(e) {
            var notificationId = $(this).data('notificationid');
            submit(notificationId);
        });

        function submit(notificationId) {
            var formData = new FormData();
            NProgress.start();

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PATCH');
            $.ajax('/dashboard/notifications/' + notificationId, {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                },
                error: function () {
                    NProgress.done();
                },
                complete: function () {
                    NProgress.done();
                },
            });
        }
    });
</script>
@endpush