<div class="wb-calendar-box">
  <!-- THE CALENDAR -->
  <div class="button-block">
    <div class="row">
      <div class="col-sm-6">
        <button type="button" class="btn btn-default">TABLE VIEW</button>
        <button type="button" class="btn btn-default btn-checked"><span class="check"><i class="fa fa-check"></i></span>CALENDAR VIEW</button>
      </div>
      <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-default btn-checked"><span class="check"><i class="fa fa-check"></i></span>YEAR VIEW</button>
        <button type="button" class="btn btn-default">MONTH VIEW</button>
      </div>
    </div>

  </div>
  <div id="calendar_1"></div>
</div>

@push('scripts')
  <script>
  $(function () {

      var date = new Date()
      var d    = date.getDate(),
          m    = date.getMonth(),
          y    = date.getFullYear()
      $('#calendar_1').fullCalendar({
        header    : {
          left  : 'prev',
          center: 'title',
          right : 'next'
        },
        prev: 'left-single-arrow',
        next: 'right-single-arrow',
        titleFormat: 'MMMM',
        //Random default events
        events    : [],
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
        drop      : function (date, allDay) { // this function is called when something is dropped
          // retrieve the dropped element's stored Event Object
          var originalEventObject = $(this).data('eventObject')
          // we need to copy it, so that multiple events don't have a reference to the same object
          var copiedEventObject = $.extend({}, originalEventObject)
          // assign it the date that was reported
          copiedEventObject.start           = date
          copiedEventObject.allDay          = allDay
          copiedEventObject.backgroundColor = $(this).css('background-color')
          copiedEventObject.borderColor     = $(this).css('border-color')
          // render the event on the calendar
          // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
          $('#calendar_1').fullCalendar('renderEvent', copiedEventObject, true)
          // is the "remove after drop" checkbox checked?
          if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove()
          }
        }
      })
      /* ADDING EVENTS */
      var currColor = '#3c8dbc' //Red by default
      //Color chooser button
      var colorChooser = $('#color-chooser-btn')
      $('#color-chooser > li > a').click(function (e) {
        e.preventDefault()
        //Save color
        currColor = $(this).css('color')
        //Add color effect to button
        $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
      })
      $('#add-new-event').click(function (e) {
        e.preventDefault()
        //Get value and make sure it is not null
        var val = $('#new-event').val()
        if (val.length == 0) {
          return
        }
        //Create events
        var event = $('<div />')
        event.css({
          'background-color': currColor,
          'border-color'    : currColor,
          'color'           : '#fff'
        }).addClass('external-event')
        event.html(val)
        $('#external-events').prepend(event)
        //Add draggable funtionality
        init_events(event)
        //Remove event from text input
        $('#new-event').val('')
      })
    })
  </script>
@endpush
