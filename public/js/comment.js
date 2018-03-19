$(document).ready(function () {
	$('[data-key]').hide()
	$('[data-value]').click(function()
	{
	  $('[data-key = '+$(this).attr('data-value')+']').show()
	  $('[data-id = '+$(this).attr('data-value')+']').hide()
	})
	$('.cancel').click(function()
	{
	  $('[data-id = '+$(this).attr('data-value')+']').show()
	  $('[data-key = '+$(this).attr('data-value')+']').hide()  
	})
	$('[data-parent]').hide()
	$('.answer').click(function()
	{
	  $('[data-parent = '+$(this).attr('data-value')+']').show()
	})
	$('.cancel_parent').click(function()
	{
		$('[data-parent = '+$(this).attr('data-value')+']').hide()
	})
})