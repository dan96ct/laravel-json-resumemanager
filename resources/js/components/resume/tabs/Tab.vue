<template>
  <BTab title-link-class="p-2">
    <template #title >
        <div class="d-flex justify-content-center">
            <div>
                <i :class="icon" style="font-size: 20px;"></i>
            </div>
            <div class="ms-2 d-none d-md-block ">
                {{ title }}
            </div>
        </div>
    </template>
        <slot></slot>
  </BTab>
</template>

<script>
import {BTab} from 'bootstrap-vue';
export default {
    name: 'Tab',
    props:{
        title:{
            type: String,
            required: true
        },
        icon:{
            type: String,
            required: true
        }
    },
    components:{
        BTab
    }
}
</script>