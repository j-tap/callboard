<template lang="pug">
div
	v-select(
		:error-messages="err.categories ? err.categories : errors.collect('category')"
		v-model='categorySelected'
		@change='categorySelectedEvt'
		:items='categories'
		item-text="name"
        item-value="id"
		v-validate="'required|categorySelected'"
		data-vv-as='Категория'
		data-vv-name='category'
		class='mb-3'
		placeholder='Категория' 
		title='Выберите категорию'
		appendIcon='expand_more'
		:light='true'
		return-object
		solo
	)
	v-select(
		v-if='categorySelected.id && categorySelected.items.length > 1'
		v-model='subCategorySelected'
		@change='subCategorySelectedEvt'
		:items='categorySelected.items'
		item-text="name"
        item-value="id"
		appendIcon='expand_more'
		class='mb-3'
		placeholder='Подкатегория' 
		title='Выберите подкатегорию'
		return-object
		:light='true'
		solo
	)
	v-select(
		v-if='subCategorySelected.id && subCategorySelected.items.length > 1'
		v-model='subSubCategorySelected'
		@change='subSubCategorySelectedEvt'
		:items='subCategorySelected.items'
		item-text="name"
        item-value="id"
		appendIcon='expand_more'
		placeholder='Подкатегория' 
		title='Выберите подкатегорию'
		:light='true'
		return-object
		solo
	)

</template>

<script>
import { Validator } from 'vee-validate';

export default {
	inject: ['$validator'],
	props: {
		category: Object,
		err: Object
	},
	data() {
		return {
			allCategories: [],
			categories: [],
			categorySelected: this.getCategoryFormat('Категория'),
			subCategorySelected: {},
			subSubCategorySelected: {},
			categorySelectedFinal: null,
		};
	},
	computed: {},
	methods: {
		categorySelectedEvt (cat)
		{
			this.subCategorySelected = this.getCategoryFormat('Подкатегория')
			this.subSubCategorySelected = this.getCategoryFormat('Подкатегория')
			this.selectedEvt()
		},
		subCategorySelectedEvt (cat)
		{
			this.selectedEvt()
		},
		subSubCategorySelectedEvt (cat)
		{
			this.selectedEvt()
		},
		selectedEvt ()
		{
			this.categorySelectedFinal = this.categorySelected

			if (this.subCategorySelected.id) {
				this.categorySelectedFinal = this.subCategorySelected
			}
			if (this.subSubCategorySelected.id) {
				this.categorySelectedFinal = this.subSubCategorySelected
			}
			
			this.$emit('setCategoryEmit', this.categorySelectedFinal.id)
		},

		getCategories () 
		{
			axios
				.get('/api/v1/category/tree')
				.then(resp => {
					this.allCategories = resp.data.data
					this.categories = [this.getCategoryFormat('Категория')]
					
					Object.assign(this.categories, this.generateCatsArray(resp.data.data))

					this.defineCategory(this.category)
				})
				.catch(error => {
					this.error = error
				})
		},

		generateCatsArray (arr, label = 'Категория') // Add object default category
		{
			let itemsArr = [this.getCategoryFormat(label)]
			for (let i in arr) {
				arr[i].items = this.generateCatsArray(arr[i].items, 'Подкатегория')
				itemsArr.push(arr[i])
			}
			return itemsArr
		},
		getCategoryFormat(name = 'Категории', id = null, items = null) { // For need format
			return { id: id, name: name, items: items };
		},
		getCatFromListById (id)
		{
			for (let i = 0; i < this.allCategories.length; i++) {
				const cat = this.allCategories[i]
				if (cat.id == id) return cat

				if (this.allCategories[i].items && this.allCategories[i].items.length) {
					for (let n = 0; n < this.allCategories[i].items.length; n++) {
						const subCat = this.allCategories[i].items[n]
						if (subCat.id == id) return subCat

						if (subCat.items && subCat.items.length) {
							for (let k = 0; k < subCat.items.length; k++) {
								const subSubCat = subCat.items[k]
								if (subSubCat.id == id) return subSubCat
							}
						}
					}
				}
			}
			return null;
		},
		defineCategory (cat)
		{ // define selected categories
			const curCategory = this.getCatFromListById(cat.id)
			
			if (curCategory) {
				if (curCategory.parent_id == 0) { // if root category
					let itemsArr = curCategory.items
					this.categorySelected = curCategory
				} 
				else { // if not root category
					const parentCategory = this.getCatFromListById(curCategory.parent_id)

					if (parentCategory.parent_id == 0) { // if root parent category
						let itemsArr = parentCategory.items
						parentCategory.items = itemsArr

						this.categorySelected = parentCategory
						this.subCategorySelected = curCategory

					} 
					else { // if not root parent category
						const parentSubCategory = this.getCatFromListById(parentCategory.parent_id)
						let itemsArr = parentCategory.items
						let itemsSubArr = parentSubCategory.items
						parentSubCategory.items = itemsSubArr
						parentCategory.items = itemsArr

						this.categorySelected = parentSubCategory
						this.subCategorySelected = parentCategory
						this.subSubCategorySelected = curCategory
					}
				}
			}
		}
	},
	created() {
		Validator.extend('categorySelected', {
			getMessage: field => 'Необходимо выбрать категорию.',
			validate: id => (this.categorySelected.id ? true : false)
		});
	},
	mounted() {
		this.getCategories();
	},

	watch: {
		category (cat)
		{
			this.defineCategory(cat)
		}
	}
};
</script>