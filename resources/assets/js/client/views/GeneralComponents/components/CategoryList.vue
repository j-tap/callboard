<template lang="pug">
.categories-wrap
	ul.categories-list
		li.categories-list-item
			button.category-label(
				type='button'
				@click.stop="selectCategory({id: null, name: 'Все категории'})"
				@mouseover='closeSubcategories'
			)
				span(class='tile grey')
				span Все категории

		li.categories-list-item(v-for='cat in categoryList')
			button.category-label(
				type='button'
				@click.stop='clickCategoryEvt(cat)'
				@mouseover='hoverCategoryEvt(cat)'
				:class="{'active': cat.id === currentCategory.id}"
			)
				span(:class="'tile ' + (cat.cl_background || 'grey')")
					component(:is='cat.cl_icon')
				span {{cat.name}}

	.subcategories
		.subcategories-list(:class="{'active': isSubShow}")
			.subcategories-head(
				@click='closeSubcategories'
				v-if='isTablet'
			)
				feather(type='chevron-left')
				b {{currentCategory.name}}

			ul
				li(v-for='cat in subCategories')
					a(
						href='javascript:void(0)'
						@click.stop='clickSubCategoryEvt(cat)'
						@mouseover='hoverSubCategoryEvt(cat)'
						:class="{'active': cat.id ===  currentSubCategory.id}"
					) {{cat.name}}

		.subcategories-list(:class="{'active': isSubSubShow}")
			.subcategories-head(
				@click='closeSubSubcategories'
				v-if='isTablet'
			)
				feather(type='chevron-left')
				b {{currentSubCategory.name}}

			ul
				li(v-for='cat in subSubCategories')
					a(
						href='javascript:void(0)'
						@click.stop='clickSubSubCategoryEvt(cat)'
						@mouseover='hoverSubSubCategoryEvt(cat)'
						:class="{'active': cat.id === currentSubSubCategory.id}"
					) {{cat.name}}

</template>

<script>

export default {
	data() {
		return {
			currentCategory: {},
			currentSubCategory: {},
			currentSubSubCategory: {},
			categoryList: null,
			subCategories: [],
			subSubCategories: [],
			isSubShow: false,
			isSubSubShow: false,
		}
	},
	methods: {
		loadCategories () 
		{
			axios
			.get('/api/v1/category/tree')
			.then((resp) => {
				this.categoryList = resp.data.data

				if (this.$route.query.category) 
					this.selectCategory(this.getCatFromListById(this.$route.query.category))

			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
		loadSubCategories () 
		{
			axios
			.get('/api/v1/category/tree')
			.then((resp) => {
				this.categoryList = resp.data.data;
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
		
		clickCategoryEvt (cat)
		{
			if (this.isTablet) {
				this.currentCategory = cat
				this.openSubcategories(cat)
				this.isSubShow = true
			} else {
				this.selectCategory(cat)
			}
		},
		clickSubCategoryEvt (cat)
		{
			if (this.isTablet) {
				this.currentSubCategory = cat
				this.openSubSubcategories(cat)
				this.isSubSubShow = true
			} else {
				this.selectCategory(cat)
			}
		},
		clickSubSubCategoryEvt (cat)
		{
			if (this.isTablet) {
				this.currentSubSubCategory = cat
			}
			this.selectCategory(cat)
		},

		hoverCategoryEvt (cat)
		{
			this.currentCategory = cat
			this.openSubcategories(cat)
		},
		hoverSubCategoryEvt (cat)
		{
			this.currentSubCategory = cat
			this.openSubSubcategories(cat)
		},
		hoverSubSubCategoryEvt (cat)
		{
			this.currentSubSubCategory = cat
		},

		openSubcategories (cat)
		{
			this.currentSubCategory = cat
			if (cat.id) {
				this.subCategories = cat.items
			} else {
				this.closeSubcategories()
			}
			this.closeSubSubcategories()
		},
		openSubSubcategories (cat)
		{
			this.currentSubSubCategory = cat
			if (cat.id) {
				this.subSubCategories = cat.items
			} else {
				this.closeSubSubcategories()
			}
		},

		closeSubcategories (evt)
		{
			this.currentSubCategory = {}
			this.subCategories = []
			this.closeSubSubcategories()
			if (this.isTablet) {
				this.isSubShow = false
			}
		},
		closeSubSubcategories ()
		{
			this.currentSubSubCategory = {}
			this.subSubCategories = []
			if (this.isTablet) {
				this.isSubSubShow = false
			}
		},

		selectCategory (cat)
		{
			this.$emit('categoryUpdate', {id: cat.id, name: cat.name})

			if (cat.id) 
				document.getElementById('filterBidsCategory').innerHTML = cat.name
			else
				document.getElementById('filterBidsCategory').innerHTML = ''

			if (this.isTablet) {
				this.isSubShow = false
				this.isSubSubShow = false
			}
		},

		getCatFromListById (id)
		{
			for (let i = 0; i < this.categoryList.length; i++) {
				const cat = this.categoryList[i]
				if (cat.id == id) 
					return cat

				if (this.categoryList[i].items && this.categoryList[i].items.length) {
					for (let n = 0; n < this.categoryList[i].items.length; n++) {
						const subCat = this.categoryList[i].items[n]
						if (subCat.id == id) 
							return subCat

						if (subCat.items && subCat.items.length) {
							for (let k = 0; k < subCat.items.length; k++) {
								const subSubCat = subCat.items[k]
								if (subSubCat.id == id) 
									return subSubCat
							}
						}
					}
				}
			}
			return null
		}
	},
	mounted () 
	{
		this.loadCategories()
	}
}
</script>

<style scoped lang="scss">
@import '../../../../../sass/base';

.categories-wrap {
	display: flex;
	position: relative;
	height: 100%;
}
.categories-list {
	list-style: none;
	margin: 0;
	padding: 0;
	overflow-y: auto;
	max-width: 30rem;

	@include media-breakpoint-down(md) {
		max-width: 100%;
		width: 100%;
		max-height: 100%;
		height: calc(100vh - (#{$height-header-sm} + 4rem));
		background: $white;
	}

	&-item {
		margin: 0 0 .7rem;
		padding: 0;
	}
}

$height-sub-head: 4.4rem;

.subcategories {
	margin: 0;
	padding: 0;
	font-size: 1.6rem;
	line-height: 1;
	color: $secondary;
	flex: 1;
	display: flex;
	height: 100%;

	&-head {
		display: flex;
		align-items: center;
		padding-bottom: 2rem;
		margin-left: -.5rem;
		background: $white;
		height: $height-sub-head;
		margin-top: -$height-sub-head;

		b {
			font-weight: 400;
		}
		i.feather {
			color: $primary;
		}
	}
	&-list {
		max-width: 55rem;
		min-width: 30rem;
		width: 50%;

		@include media-breakpoint-down(md) {
			padding-top: $height-sub-head;
			max-height: 100%;
			position: absolute;
			top: 0;
			left: -120%;
			background: $white;
			width: 100%;
			max-width: 100%;
			min-width: 100%;
			height: 100%;
			max-height: 100%;
			transition: left .3s ease;
		}

		&.active {
			@include media-breakpoint-down(md) {
				left: 0;
			}
		}
	}

	ul {
		padding: 0;
		margin: 0;
		width: 100%;
		list-style: none;
		border-left: .1rem solid $light-gray;
		height: 100%;
		overflow-y: auto;

		@include media-breakpoint-down(md) {
			height: 100%;
			max-height: 100%;
		}
	}
	li {
		margin: 0;
		padding: 0;

		&.active {
			a {
				color: $primary;
				text-decoration: underline;
			}
		}
	}
	a {
		display: block;
		color: inherit;
		transition: color .2s ease;
		text-decoration: none;
		padding: .7rem 1rem;

		@include media-breakpoint-down(md) {
			padding-top: 1rem;
			padding-bottom: 1rem;
		}

		&:hover,
		&:focus {
			outline: none;
			color: $primary;
		}
		&.active {
			background: $light-gray;
			color: $primary;
		}
	}
}
.current-category {
	cursor: pointer;
	display: flex;
	align-items: center;
	line-height: 1;
	margin: 0 0 2.2rem;

	.tile {
		width: 4.2rem;
		height: 4.2rem;
		margin-right: 1.2rem;

		& + span {
			font-size: 1.6rem;
			font-weight: 500;
			color: $secondary;
		}
	}
	&-prev {
		cursor: pointer;
		margin-right: 1rem;
		margin-left: -3rem;
	}
}
.category-label {
	color: $text-gray;
	display: flex;
	width: 100%;
	line-height: 1.2;
	align-items: center;
	font-size: 1.3rem;
	text-decoration: none;
	text-align: left;
	border-radius: $border-radius-sm 0 0 $border-radius-sm;
	transition: color .2s ease, background .2s ease;

	&:hover,
	&:focus {
		outline: none;
		color: $primary;
	}
	&.active {
		background: $light-gray;
		color: $primary;

		.tile {
			box-shadow: $box-shadow;
		}
	}
	
	.tile {
		width: 3.5rem;
		height: 3.5rem;
		margin: 0 1rem 0 0;
		flex-shrink: 0;
		box-shadow: none;

		&:focus,
		&:hover {
			transform: scale(1);
		}
		svg {
			width: 2.4rem;
			height: 2.4rem;
		}
		& + span {
			padding-right: 1rem;
		}
	}
}
</style>	