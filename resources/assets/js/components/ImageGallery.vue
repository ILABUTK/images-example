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

</div>

</template>

<script>

export default {
  name: 'image-gallery',
  data(){
    return {
      images : [],
      largeImage: null,
    };
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
  },
  updated(){
    window.Macy.onImageLoad(null, function () {
      window.Macy.recalculate();
    });   
  },
  methods: {
    addImage(image){
      // this.images.unshift(image);
      //retrieve data with updated time
      window.axios.get('/images').then(response => this.images = response.data); 
    },
    showLargeImage(image){
      this.largeImage = image;
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

