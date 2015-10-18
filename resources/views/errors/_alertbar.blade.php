{{-- styles --}}
<style type="text/css">
	.alert {
	  padding: 20px;
	  background-color: #D04747;
	  z-index: 2000;
	  position: fixed;
	  left: 0;
	  right: 0;
	  top: 0;
	  text-align: center;
	}

	.alert span {
		font-family: 'raleway';
		display: block;
		font-size: 15px;
		color: #fff;
	}

	.alert img {
    width: 20px;
    cursor: pointer;
    position: absolute;
    top: 50%;
    margin-top: -10px;
    right: 10px;
	}
</style>

{{-- markup --}}
<div class="alert">
	<img class="close" src="{{ asset('/img/close.png') }}">
	@foreach ($errors as $error)
   	<span>{{ $error }}</span>
  @endforeach
</div>

{{-- script --}}
<script type="text/javascript" src="{{ asset('/vendor/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
	$('.close').on('click', function () {
		$('.alert').slideUp('5000', function () {
			$(this).remove();
		});
	});
</script>