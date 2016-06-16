/**
 * Created by ET on 6/14/2015.
 */
$(document).ready(function() {

    //Action when submit is clicked
    //e is an event object to get the preventDefault() method which is used to prevent the default action of the element
    //$('.item-add').on('click', '.submit', function(e)
    //Had a problem that the ajax wouldn't work property refreshes and found out the problem is because of binding. and someone gave me the commet from below.

    //You are binding your event handlers when the page opens / the DOM is ready, on $(document).ready(). Then you add new items using ajax but the links in these items will not have your event handlers bound to them.
    //You can use event delegation to make sure that the events are also automatically bound to newly added items.
    $('.item-add').on('click', '.submit', function(e){
        var todoText = $("input[name='todoText']").val();
        e.preventDefault();

        //Ajax for adding todoText
        $.ajax({
            method: "POST",
            url: "add-ajax.php",
            data: {todoText: todoText},
            dataType: "json"
        })
            .done(function(data){
                $('p.empty').empty();
                $('input.input').val('');
                $('ul.items').append('<li><span>'+todoText+' '+
                '</span><a href="done-ajax.php?as=done&item=' + data.id +
                '" class="done-button">Mark as Done</a></li>');
            })
    });// end .item-add on click

    /* doubleD() */
    //function for when done  / delete button is clicked
    //where the $("ul.item") can be any element that contains the newly added elements and that is on the page when this code executes.
    //This applies to all event handlers that you want to bind to elements that are not yet on the page when the DOM is ready.
    //Which means do not use $('li') use it's parent or further using ('.list') would work too
    function doubleD(button){
        $('ul.items').on('click', button, function(e){
            e.preventDefault();

            //making sure only work with the current element
            var $clicked = $(this);

            //get the href attribute value and parse it to get the item # which is the item's id
            var attrValue = $clicked.attr('href');
            var parseAttrValue = attrValue.split('&');
            var parseItem = parseAttrValue[1].split('=');
            var item = parseItem[1];

            if(button == '.done-button'){
                //Ajax for Mark as Done Button
                $.ajax({
                    method: "GET",
                    data:{as: 'done', item: item},
                    url: "done-ajax.php"
                })
                    .done(function(){
                        $clicked.prev().addClass('item done');
                        $clicked.removeClass('done-button').empty();
                        $clicked.addClass('delete-button').text('Delete Task');
                        $clicked.removeAttr('href');
                        $clicked.attr('href','delete-ajax.php?as=delete&item='+item);
                    });
            }

            if(button == '.delete-button'){
                //Ajax for Delete Task Button
                $.ajax({
                    method: "GET",
                    data:{as: 'delete', item: item},
                    url: "delete-ajax.php"
                })
                    .done(function(){
                        $clicked.closest('li').remove();
                        $clicked.remove();
                    });
            }
        });
    } //end doubleD()

    doubleD('.done-button');
    doubleD('.delete-button');

}); // end document ready