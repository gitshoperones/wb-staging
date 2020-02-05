<script>
    @auth
        console.log('authenticated@public')
        window.intercomSettings = {
            app_id: "n3f381pz",
            name: "{{ Auth::user()->fname }} {{ Auth::user()->lname }}", // Full name
            email: "{{ Auth::user()->email }}", // Email address,
            phone: "{{ Auth::user()->phone_number }}",
            couple_name: '{{ \App\Models\Couple::where('userA_id', Auth::user()->id)->first(['id', 'title'])->title ?? '' }}',
            business_name: '{{ \App\Models\Vendor::where('user_id', Auth::user()->id)->first(['id', 'business_name'])->business_name ?? '' }}',
            created_at: "{{ strtotime(now()) }}" // Signup date as a Unix timestamp
        };

        $('.sign-out').click(function() {
            console.log('sign out..');
            Intercom('shutdown')
        });
	@endauth

	@guest
        console.log('guest@public')
        window.intercomSettings = {
            app_id: "n3f381pz"
        };
	@endguest
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/n3f381pz';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>