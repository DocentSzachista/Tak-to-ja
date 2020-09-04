
// document.addEventListener('DOMContentLoaded', function () {
//   var calendarEl = document.getElementById('calendar');

//   var calendar = new FullCalendar.Calendar(calendarEl, {
//     headerToolbar: {
//       left: 'prev,next today',
//       center: 'title',
//       right: 'dayGridMonth,timeGridWeek,timeGridDay'
//     },
//     initialDate: '2020-06-07',
//     navLinks: true, // can click day/week names to navigate views
//     selectable: true,
//     selectMirror: true,
//     select: function (arg) {
//       var title = prompt('Event Title:');
//       if (title) {
//         calendar.addEvent({
//           title: title,
//           start: arg.start,
//           end: arg.end,
//           allDay: arg.allDay
//         })
//       }
//       calendar.unselect()
//     },
//     eventClick: function (arg) {
//       if (confirm('Are you sure you want to delete this event?')) {
//         arg.event.remove()
//       }
//     },
//     editable: true,
//     dayMaxEvents: true, // allow "more" link when too many events
//     events: [
//       {
//         title: 'All Day Event',
//         start: '2020-06-01'
//       },
//       {
//         id: '1',
//         title: 'Long Event',
//         start: '2020-06-07',
//         end: '2020-06-10',
//         subject: "python",
//         desc: "",
//         daysOfWeek: [0,1],
//         startRecur: '2020-06-07',
//         endRecur: '2020-07-06'
//       },
//       {
//         groupId: 888,
//         title: 'Repeating Event',
//         start: '2020-06-09T16:00:00'
//       },
//       {
//         groupId: 999,
//         title: 'Repeating Event',
//         start: '2020-06-16T16:00:00'
//       },
//       {
//         title: 'Conference',
//         start: '2020-06-11',
//         end: '2020-06-13'
//       },
//       {
//         title: 'Meeting',
//         start: '2020-06-12T10:30:00',
//         end: '2020-06-12T12:30:00'
//       },
//       {
//         title: 'Lunch',
//         start: '2020-06-12T12:00:00'
//       },
//       {
//         title: 'Meeting',
//         start: '2020-06-12T14:30:00'
//       },
//       {
//         title: 'Happy Hour',
//         start: '2020-06-12T17:30:00'
//       },
//       {
//         title: 'Dinner',
//         start: '2020-06-12T20:00:00'
//       },
//       {
//         title: 'Birthday Party',
//         start: '2020-06-13T07:00:00'
//       },
//       {
//         title: 'Click for Google',
//         url: 'http://google.com/',
//         start: '2020-06-28'
//       }
//     ]
//   });
  


//   calendar.render();
//   var event = calendar.getEventById('1');
//   console.log(event)
// });
