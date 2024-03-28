// import './bootstrap';
// import './map';

    // Show loading spinner on DOMContentLoaded
//     document.addEventListener('DOMContentLoaded', function() {
//         var loadingElement = document.getElementById('loading');
//         if (loadingElement) {
//             loadingElement.style.display = 'block'; // or 'inline' or your desired display property
//         }
//         console.log('asdf');
//     });

//     // Hide loading spinner when the page is fully loaded
//     window.addEventListener('load', function() {
//         var loadingElement = document.getElementById('loading');
//         if (loadingElement) {
//             loadingElement.style.display = 'none';
//         }
//         console.log('asdf');
//     });

//     $(document).ready(function() {
//         $('#paymentMethodSelect').select2({
//             templateResult: formatOption
//         });
//     });

//     function formatOption(option) {
//         // If the option does not have an image, return it unchanged
//         if (!option.id) {
//             return option.text;
//         }

//         // Create a jQuery object to hold the option text and image
//         var $option = $(
//             '<span><img src="' + $(option.element).data('image') + '" class="img-option" /> ' + option.text + '</span>'
//         );

//         return $option;
//     }

//     //test for getting url value from attr
//     var img2 = 'asdsad';
// var img1 = $('.test').attr("data-thumbnail");
// console.log(img2);

// //test for iterating over child elements
// var langArray = [];
// $('.vodiapicker option').each(function(){
// var img = $(this).attr("data-thumbnail");
// var text = this.innerText;
// var value = $(this).val();
// var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
// langArray.push(item);
// })

// $('#a').html(langArray);

// //Set the button value to the first el of the array
// $('.btn-select').html(langArray[0]);
// $('.btn-select').attr('value', 'en');

// //change button stuff on click
// $('#a li').click(function(){
// var img = $(this).find('img').attr("src");
// var value = $(this).find('img').attr('value');
// var text = this.innerText;
// var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
// $('.btn-select').html(item);
// $('.btn-select').attr('value', value);
// $(".b").toggle();
// //console.log(value);
// });

// $(".btn-select").click(function(){
//     $(".b").toggle();
// });

// //check local storage for the lang
// var sessionLang = localStorage.getItem('lang');
// if (sessionLang){
// //find an item with value of sessionLang
// var langIndex = langArray.indexOf(sessionLang);
// $('.btn-select').html(langArray[langIndex]);
// $('.btn-select').attr('value', sessionLang);
// } else {
// var langIndex = langArray.indexOf('ch');
// console.log(langIndex);
// $('.btn-select').html(langArray[langIndex]);
// //$('.btn-select').attr('value', 'en');
// }

