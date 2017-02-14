<template>
  <div class="columns files is-multiline" name="image" is="transition-group">
      <div v-for="image in images" :key="image.id" class="column is-4-tablet is-3-desktop is-2-widescreen">
        <a class="file">
          <div class="image">
                <img :src="image.path" alt="Image">
          </div>
          <div class="name"> {{image.name}} </div>
          <div class="timestamp"> {{image.human_time}} </div>
        </a>
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
    window.axios.get('/images').then(response => this.images = response.data)
  },
  methods: {
    addImage(image){
      this.images.unshift(image);
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
</style>

