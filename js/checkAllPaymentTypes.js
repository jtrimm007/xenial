function selectAllPayment(ele)
{
    var selectallPayment = document.getElementsByName("checkAllPayment");
    var checkboxes = document.getElementsByName("paymentAccepted[]");

    if(ele.checked)
    {
        for(var i = 0; i < checkboxes.length; i++)
        {
            if(checkboxes[i].type == "checkbox")
            {
                checkboxes[i].checked = true;
            }

            checkboxes[i].check = ele.checked;
        }
    }
    else
    {
        for ( var i = 0; i < checkboxes.length; i++)
        {
            if ( checkboxes[i].type == "checkbox")
            {
                checkboxes[i].checked = false;
            }
        }
    }
}