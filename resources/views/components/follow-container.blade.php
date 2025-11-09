@props(['user'])

<div {{ $attributes }} x-data="{
    {{-- following: Checks if the logged-in user is following the $user. --}}
    following: {{ $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
        {{-- followersCount: Total number of followers the $user has, rendered as a static number. --}}
    followersCount: {{ $user->followers()->count() }},
        follow() {
            this.following = !this.following
            axios.post('/follow/{{ $user->id }}')
                .then(res => {
                    console.log(res.data)
                    this.followersCount = res.data.followersCount
                })
                .catch(err => {
                    console.log(err)
                })
        }
}" class="w-[320px] px-8" style="border-left: 1px solid #efefef">
    {{ $slot }}
</div>
