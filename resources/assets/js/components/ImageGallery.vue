<template>
<!-- class="columns files is-mobile is-multiline" -->
<!-- class="column is-6-mobile is-4-tablet is-3-desktop is-2-widescreen"  -->
  <div id="macy-container" name="image" is="transition-group">
      <div v-for="image in images" :key="image.id">
      <div class="card">
        <a class="file">
          <figure class="image">
              <img :src="image.preview_path" :alt=" image.name ">
          </figure>    
          <div class="name"> {{image.name}} </div>
          <div class="timestamp"> {{image.human_time}} </div>
        </a>        
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
    window.Macy.onImageLoad(function () {
      window.Macy.recalculate();
    });   
  },
  methods: {
    addImage(image){
      // this.images.unshift(image);
      //retrieve data with updated time
      window.axios.get('/images').then(response => this.images = response.data); 
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

