<template lang="pug">
.files-photo-list
	ul
		li(
			:class="{'isphoto': (preloadImages[ind] || imagesUploaded[ind])}"
			v-for='(n, ind) in count'
		)
			.file-photo
				b-form-file(
					title='Загрузите фотографию'
					v-model='images[ind]'
					@change='onImagesChange($event, ind)'
					placeholder='Выберите фотографии'
					:data-vv-as="'Фото '+ ind"
					:data-vv-name="'images-'+ ind"
					v-validate="'isImg'"
					:inputClass="(err['images-'+ ind] || errors.first('images-'+ ind)) ? 'is-invalid' : ''"
					:class="(err['images-'+ ind] || errors.has('images-'+ ind)) ? 'is-invalid' : ''"
				)
				.i.i--no-photo(v-show='!preloadImages[ind] && !imagesUploaded[ind]')

				img(
					v-show='preloadImages[ind]'
					@click='deleteImage(ind)'
					:src='preloadImages[ind]'
					alt=' '
				)
				img(
					v-if='imagesUploaded[ind]'
					@click='deleteImage(ind, imagesUploaded[ind].id)'
					:src='imagesUploaded[ind].path'
					alt=' '
				)

				.invalid-feedback {{ err['images-'+ ind] ? err['images-'+ ind] : errors.first('images-'+ ind) }}

</template>

<script>
import { Validator } from 'vee-validate'

export default {
	props: {
		imagesUploaded: [Array, Boolean],
		count: {
			type: Number,
			default: 1
		},
		err: Object,
	},
	data() {
		return {
			loading: false,
			preloadImagesTmp: [],
			preloadImages: [],
			images: [],
		}
	},
	computed: {},
	methods: {
		onImagesChange (evt, ind)
		{
			if (window.FileReader) {
				const file = evt.target.files[0]

				if (file && file.type && file.type.indexOf('image') >= 0) {
					let reader = new FileReader()

					reader.readAsDataURL(file)
					reader.onload = function (e) {
						const img = reader.result

						this.updPreloadImages(ind, img)
						this.$emit('setImagesEmit', this.images)
					}.bind(this)
				} 
				else {
					this.printErrorOnConsole('Error file type!', 'warning')
					this.$emit('setImagesEmit', this.images)
				}
			}
		},

		deleteImage (index, imgId)
		{
			if (imgId) {
				axios
				.post('/api/v1/deals/deleteimage', {id: imgId})
				.then((resp) => {
					this.imagesUploaded.splice(index, 1)
				})
				.catch(error => {
					this.printErrorOnConsole(error)
				})
			}
			this.updPreloadImages(index, null)
		},

		updPreloadImages (ind, val)
		{
			if (typeof ind === 'number' && typeof val !== 'undefined') {
				this.preloadImagesTmp[ind] = val
				this.preloadImages = []
				this.preloadImages = this.preloadImagesTmp
			} 
			else { 
				this.cleanPreloadImages()
			}
		},
		cleanPreloadImages (ind)
		{
			if (ind) {
				this.preloadImagesTmp[ind] = null
			} 
			else { 
				this.preloadImagesTmp = []
			}
			this.preloadImages = []
			this.preloadImages = this.preloadImagesTmp
		}
	},
	watch: {},
	mounted() {
		Validator.extend('isImg', {
			getMessage: field => 'Разрешены только изображения',
			validate: value => {
				const extArr = ['png', 'jpg', 'jpeg', 'gif', 'bmp']
				const ext = value.name.split('.').pop()
				
				return (extArr.indexOf(ext) >= 0)
			}
		})
	}
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.files-photo-list {
	display: block;
	list-style: none;
	margin: 0 -.3rem;
	padding: 0;
	font-size: 0;

	ul {
		margin: 0;
		padding: 0;
		list-style: none;
	}

	li {
		display: none;
		vertical-align: top;
		padding: 0 .3rem .6rem;
		margin: 0;
		width: 25%;

		&.isphoto {
			display: inline-block;
			
			& + li {
				display: inline-block;
			}
		}
		&:first-child {
			display: inline-block;
		}
		&:first-child:not(:last-child) {
			&::after {
				content: 'Главная фотография';
				color: $primary;
				font-size: 1.4rem;
				display: block;
				text-align: center;
				line-height: 1;
				padding-top: .5rem;

				@include media-breakpoint-down(sm) {
					font-size: 1.2rem;
				}
			}
			.file-photo {
				border-color: $primary;
			}
		}
	}
}
.file-photo {
	overflow: hidden;
	position: relative;
	border-radius: $border-radius;
	border: .1rem solid $light;
	height: 10rem;
	line-height: 10rem;
	text-align: center;

	@include media-breakpoint-down(sm) {
		height: 16vw;
		line-height: 16vw;
	}
	
	.b-form-file {
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
		padding: 0;
		margin: 0;
		z-index: 2;
		cursor: pointer;

		input {
			font-size: 10rem;
			cursor: pointer;
		}
	}
	.i {
		max-width: 80%;
		max-height: 80%;
	}
	img {
		@include imgAbsCenter();
		z-index: 2;
	}
}
</style>