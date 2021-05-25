<template>
<div>

<div class="bg-white mb-3">
        <nav class="flex flex-col sm:flex-row">
            <button @click="getPost()" class="w-2/4 text-gray-600 py-4 px-6 block hover:text-red-500 focus:outline-none " v-bind:class="[style1]">
                Recent
            </button>
            <button @click="gettrendingpost()" class="w-2/4 text-gray-600 py-4 px-6 block hover:text-red-500 focus:outline-none" v-bind:class="[style2]">
                Trending
            </button>
        </nav>
</div>

<div v-for="post in posts" :key="post.id" class="px-5 mb-3 py-4 bg-white dark:bg-gray-800 shadow rounded-lg max-w-full">
<div class="flex justify-between items-center">
    <div class="flex mb-4">
      <img class="w-12 h-12 rounded-full" src="https://www.logolynx.com/images/logolynx/97/97e88682fa82ed11f3bf96dcf8479635.png"/>
      <div class="ml-2 mt-0.5">
        <div v-if="post.anonymous == ''">
          <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">{{post.username}}</span>
        </div>
        <div v-else>
          <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">{{post.anonymous}}</span>
        </div>
       
        <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{ post.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
       
      </div>
    </div>
    <div>

<div class="relative inline-block text-left" >
  <div>
    <button type="button" @click="showitems = post" class="inline-flex justify-center w-full rounded-md px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-expanded="true" aria-haspopup="true">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
        </svg>
    </button>
  </div>
 <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
    <div class="py-1"  role="none" v-show="showitems == post">
        <button @click="deletePost(post.id)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
          Delete
        </button>
        <div v-if="post.status == '0'">
        <button @click="seenPost(post.id)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
          Mark post as <b>Seen by Admin</b>   
        </button>
        </div>
    </div>
  </div>
</div>



    <!-- <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
    </svg>  -->
    </div>
</div>

    <!-- @if($post->status === 'true')
    <p id="notice_tag"><b><icon class="material-icons" style="font-size: 15px;">check_circle</icon> Noticed by USeP admin </b></p>
    @endif -->

    <!-- <p><svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">3</span>
    </p> -->

     <div class="flex mr-5" v-if="post.status == '1'">
        <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white text-green-500 dark:bg-gray-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-green-500 dark:text-gray-400 font-light">Noticed by USeP admin</span>
    </div> 
    <div v-else>

    </div>

    <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal text-lg font-bold mb-3">
    {{post.title}}
    </p>
    

    <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">
    {{post.description}}
    </p>
   
   <a :href="('/post/' + post.id)">
    <div class="flex justify-right items-center mt-5 pt-3 border-t-2 border-gray-200">
        <div class="flex mr-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{post.upvote_count}}</span>
        </div> 
        <div class="flex mr-5">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{post.downvote_count}}</span>
        </div>
        <div class="flex mr-5">
                <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">comments</span>
        </div> 
    </div>
    </a>

</div>
</div>
</template>
<script>
export default {

    name: 'dropdown',
    data(){
        return {
            posts: '',
            state: false,
            showitems: -1,
            tabnavigator: "text-red-500 border-b-2 font-medium border-red-500",
            style1: '',
            style2: '',
        }
    },

    methods:{

                onBeforeOpen () {
                    // you can add a condition to cancel the modal opening
                    if (false) {
                        cancel()
                    }
                    this.user = params.user
                    },
        getPost()
        {
            this.style1 = this.tabnavigator,
            this.style2 = '',
            axios.get('/getposts').
            then((response) => 
            {
                this.posts = response.data.postsdata
            }).catch((error) => 
            {
                console.log(error)
            })
        },
        gettrendingpost()
        {
          this.style2 = this.tabnavigator,
          this.style1 = '',
           axios.get('/getposts').
            then((response) => 
            {
                this.posts = response.data.trendingpostdata
            }).catch((error) => 
            {
                console.log(error)
            })
        },
        deletePost(id)
        {
             axios.delete(`getposts/${id}`)
                .then(response => {
                    let i = this.posts.map(data => data.id).indexOf(id);
                    this.posts.splice(i,1)
                });
        },
        seenPost(id)
        {
            axios.patch(`getposts/${id}`)
            .then(response => {
                console.log(response)
                this.getPost()
            });
        },
        close (e) {
            if (!this.$el.contains(e.target)) {
                //this.state = false
                this.showitems = 0
            }
        },
    },

   
   

     mounted()
        {
            this.getPost()
            document.addEventListener('click', this.close)
        },
         
    beforeDestroy () {
            document.removeEventListener('click',this.close)
            }
}
</script>