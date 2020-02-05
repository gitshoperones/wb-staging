<form id="review-form" class="form-inline" method="POST" action="{{ $url ?? url('/vendor-review') }}">
    {{ csrf_field() }}
    <input type="hidden" name="code" value="{{ $code ?? '' }}">
    <input type="hidden" id="jobQuoteId" name="jobQuoteId" value="{{ request('job-quote-id') ?? '' }}">
    <p>Event Type</p>
    <div class="form-group">
        <select class="form-control" id="event-type" name="event_type">
            <option value="">Select</option>
            @foreach($eventTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
            @endforeach
        </select>
        <br/><br/>
    </div>
    <p>Event Date</p>
    <div class="form-group">
        <select class="form-control" id="event-m" name="event_month">
            <option value="">Month &nbsp;&nbsp;&nbsp;&nbsp;</option>
            @for($i = 1; $i < 13; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" id="event-y" name="event_year">
            <option value="">Year &nbsp;&nbsp;&nbsp;&nbsp;</option>
            @for($i = now()->format('Y'); $i >= 1990; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <br/><br/>
    <p>Ease to work with</p>
    <div class="rating" id="easy_to_work_with">
        <a class='star' title='Poor' data-value='1'><i class="fa fa-star"></i></a>
        <a class='star' title='Fair' data-value='2'><i class="fa fa-star"></i></a>
        <a class='star' title='Good' data-value='3'><i class="fa fa-star"></i></a>
        <a class='star' title='Excellent' data-value='4'><i class="fa fa-star"></i></a>
        <a class='star' title='Outstanding' data-value='5'><i class="fa fa-star"></i></a>
        <input type="hidden" class="value-per-rating" id="easy_to_work_with-input" name="easy_to_work_with">
    </div>
    <br/>
    <p>Likelihood of recommending your business</p>
    <div class="rating" id="likely_to_recoment_to_a_friend">
        <a class='star' title='Poor' data-value='1'><i class="fa fa-star"></i></a>
        <a class='star' title='Fair' data-value='2'><i class="fa fa-star"></i></a>
        <a class='star' title='Good' data-value='3'><i class="fa fa-star"></i></a>
        <a class='star' title='Excellent' data-value='4'><i class="fa fa-star"></i></a>
        <a class='star' title='Outstanding' data-value='5'><i class="fa fa-star"></i></a>
        <input type="hidden" class="value-per-rating" id="likely_to_recoment_to_a_friend-input" name="likely_to_recoment_to_a_friend">
    </div>
    <br/>
    <p>Overall Satisfaction?</p>
    <div class="rating" id="overall_satisfaction">
        <a class='star' title='Poor' data-value='1'><i class="fa fa-star"></i></a>
        <a class='star' title='Fair' data-value='2'><i class="fa fa-star"></i></a>
        <a class='star' title='Good' data-value='3'><i class="fa fa-star"></i></a>
        <a class='star' title='Excellent' data-value='4'><i class="fa fa-star"></i></a>
        <a class='star' title='Outstanding' data-value='5'><i class="fa fa-star"></i></a>
    </div>
    <input type="hidden" class="value-per-rating" id="overall_satisfaction-input" name="overall_satisfaction">
    <br/>
    <p>Please provide any additional comments about their service.</p>
    <input id="average-rating" type="hidden" name="rating" value="0">
    <div class="form-group">
        <textarea name="message" id="message" class="form-control" cols="60" rows="10" maxlength="350"></textarea>
        <p><i id="message-characters-count"></i> characters remaining</p>
    </div>
    <br/><br/>
    <div class="form-group">
        <input type="submit" id="submit-my-review" class="btn wb-btn-orange" value="Submit My Review">
    </div>
    <br/><br/>
</form>

<!-- Onboarding Modal -->
<div class="modal fade onboarding-wrapper couple step3" id="form-error-modal" role="dialog" aria-labelledby="" aria-hidden="true">
    <div id="wb-modal-couple3" class="modal-dialog">
        <div class="modal-dialog">
            <div class="icon-wrappers onboarding couple">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="modal-content text-center">
                <div class="modal-body">
                    <h2 class="title">Form Error</h2>
                    <div class="desc wide form-control" id="form-error-message"></div>
                    <br /><br />
                    <button type="button" id="close-form-error-modal" class="step2 wb-btn wb-btn-lg wb-btn-orange">Close</button>
                    <br /><br />
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var msg = '';
        var averageRating = 0;
        var totalRating = 0;

        var maxLength = 350;
        $('#message-characters-count').text(maxLength);
        $('#message').keyup(function() {
            var length = maxLength - $(this).val().length;
            $('#message-characters-count').text(length);
        });

        $('#submit-my-review').on('click', function(e){
            if (!$('#event-type').val()) {
                msg = 'Please select the event type.';
                showErrorModal();
                return false;
            }

            if (!$('#event-m').val()) {
                msg = 'Please select event month.';
                showErrorModal();
                return false;
            }

            if (!$('#event-y').val()) {
                msg = 'Please select event year.';
                showErrorModal();
                return false;
            }

            if (!$('#easy_to_work_with-input').val() || !$('#likely_to_recoment_to_a_friend-input').val() || !$('#overall_satisfaction-input').val()) {
                msg = 'All rating is required.';
                showErrorModal();
                return false;
            }

            if (!$('#message').val()) {
                msg = 'Please add your message.';
                showErrorModal();
                return false;
            }

            $('#review-form').submit();
        });

        $('#close-form-error-modal').on('click', function(){
            $('#form-error-modal').modal('hide');
        });

        $('.table, .wb-booked-box').on('click', '.submit-review', function(e){
            var notificationId = $(this).attr('data-notificationid');

            if (notificationId) {
                var formUrl = $('#form-vendor-review').attr('action');
                $('#form-vendor-review').attr('action', formUrl + '?notificationId='+ notificationId);
            }

            $('#jobQuoteId').val($(this).attr('data-jobquoteid'));
        });

        $('.rating a').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10);

            $(this).parent().children('a.star').each(function(e){
                if (e < onStar) {
                    $(this).addClass('hover');
                }
            else {
                $(this).removeClass('hover');
            }
        });

        }).on('mouseout', function(){
            $(this).parent().children('a.star').each(function(e){
                $(this).removeClass('hover');
            });
        });

        $('.rating a').on('click', function(){
            var onStar = parseInt($(this).data('value'), 10);
            var stars = $(this).parent().children('a.star');

            for (i = 0; i < stars.length; i++) {
              $(stars[i]).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
              $(stars[i]).addClass('selected');
            }

            averageRating = 0;
            totalRating = 0;
            var parent = $(this).parent();
            var parentId = parent.attr('id');
            var ratingValue = parseInt(parent.children('.rating a.selected').last().data('value'), 10);

            $('[name="'+parentId+'"]').val(ratingValue);

            $('.value-per-rating').each(function(){
                totalRating += parseInt(this.value);
            });

            averageRating = totalRating / $('.rating').length;

            intTotalRating = Math.floor(averageRating);
            decimalTotalRating = averageRating - intTotalRating;

            if (decimalTotalRating >= 0.10 && decimalTotalRating <= 0.24) {
                averageRating = intTotalRating;
            } else if (decimalTotalRating >= 0.25 && decimalTotalRating <= 0.50) {
                averageRating = intTotalRating + 0.50;
            } else if (decimalTotalRating >= 0.51 && decimalTotalRating <= 0.74) {
                averageRating = intTotalRating + 0.50;
            } else if (decimalTotalRating >= 0.75 && decimalTotalRating <= 0.99) {
                averageRating = Math.ceil(averageRating);
            }

            $('#average-rating').val(averageRating);

        });

        function showErrorModal() {
            $('#form-error-modal').modal('show');
            $('#form-error-message').text(msg);
        }
    </script>
@endpush