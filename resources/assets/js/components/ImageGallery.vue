<template>
<div>
  <div id="macy-container" name="image" is="transition-group">
      <div v-for="image in images" :key="image.id">
      <div class="card">
        <a class="file">
          <figure class="image">
              <img :src="image.preview_path" :alt=" image.name " @click="showLargeImage(image)">
          </figure>    
          <div class="name"> {{image.name}} </div>
          <div class="timestamp"> {{image.human_time}} </div>
        </a>        
      </div>
      </div>                
  </div>

  <div id="view-large" class="modal" :class="{'is-active': largeImage != null }">
    <div class="modal-background" @click="largeImage = null"></div>
    <div class="modal-content">
      <p class="image">
        <img :src="largeImage? largeImage.path : ''">
      </p>
    </div>
    <button class="modal-close" @click="largeImage = null"></button>
  </div>

  <div v-show="show_button" class="columns" style="padding-top : 40px; padding-bottom : 30px;" @click="loadMoreData()">
  <div class="column is-half is-offset-one-quarter ">
      <a class="button is-primary is-fullwidth"
         :class="{'is-disabled': button_disabled}">{{butt_text}}</a>    
  </div>
  </div>

</div>

</template>

<script>

export default {
  name: 'image-gallery',
  data(){
    return {
      images : [],
      largeImage: null,
      butt_text: 'Load more images ...',
      button_disabled:false,
      show_button:false,
    };
  },
  computed: {
    lastID(){
      let oldestImage = window._.minBy(this.images, (o) => o.id);
      if(oldestImage)
        return oldestImage.id;
      else
        return 1E20;
    }
  },
  mounted(){
    window.axios.get('/images').then(response => this.images = response.data);
    window.Macy.init({
      container: '#macy-container',
      trueOrder: false,
      waitForImages: false,
      margin: 24,
      columns: 6,
      breakAt: {
          1200: 5,
          940: 3,
          520: 2,
          400: 1
        }
    });
    setTimeout(() => { this.show_button = true; }, 1000);   
  },
  updated(){
    window.Macy.onImageLoad(null,  () => {
      window.Macy.recalculate();
    });   
  },
  methods: {
    addImage(image){
      this.images.unshift(image);
      //retrieve data with updated time
      // window.axios.get('/images').then(response => this.images = response.data); 
    },
    showLargeImage(image){
      this.largeImage = image;
    },
    loadMoreData(){
      window.axios.get('/images', { params: { lastID: this.lastID } })
                  .then(response => {
                    if(response.data.length > 0)
                      this.images.push.apply(this.images, response.data);
                    else {
                      this.butt_text = 'No more images :)';
                      this.button_disabled = true;
                    }
                  });
    }
  }
}
</script>


<style>
.image-enter-active, .image-leave-active {
  transition: all 0.5s;
}
.image-enter, .image-leave-to  {
  opacity: 0;
  transform: translateY(10px);
}
.image-move {
  transition: transform 0.5s;
}

.grid-item { width: 200px; }

</style>

