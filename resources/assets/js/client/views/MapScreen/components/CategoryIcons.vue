<template>
    <div class="flex-row f-align-center f-content-center">
        <cat-food v-if="icon == 'cat-food' || icon =='default'"></cat-food>
        <cat-tabacco v-if="icon == 'cat-tabacco' || icon =='default'"></cat-tabacco>
        <cat-clothes v-if="icon == 'cat-clothes' || icon =='default'"></cat-clothes>
        <cat-kids v-if="icon == 'cat-kids' || icon =='default'"></cat-kids>
        <cat-furniture v-if="icon == 'cat-furniture' || icon =='default'"></cat-furniture>
        <cat-householdaplience v-if="icon == 'cat-householdaplience' || icon =='default'"></cat-householdaplience>
        <cat-vehicles v-if="icon == 'cat-vehicles' || icon =='default'"></cat-vehicles>
        <cat-interiordecor v-if="icon == 'cat-interiordecor' || icon =='default'"></cat-interiordecor>
        <cat-textile v-if="icon == 'cat-textile' || icon =='default'"></cat-textile>
        <cat-householdchemicals v-if="icon == 'cat-householdchemicals' || icon =='default'"></cat-householdchemicals>
        <cat-petsuplies v-if="icon == 'cat-petsuplies' || icon =='default'"></cat-petsuplies>
        <cat-tourismsport v-if="icon == 'cat-tourismsport' || icon =='default'"></cat-tourismsport>
        <cat-beautyhealth v-if="icon == 'cat-beautyhealth' || icon =='default'"></cat-beautyhealth>
        <cat-medicalsuplies v-if="icon == 'cat-medicalsuplies' || icon =='default'"></cat-medicalsuplies>
        <cat-garden v-if="icon == 'cat-garden' || icon =='default'"></cat-garden>
        <cat-constructionmaterial v-if="icon == 'cat-constructionmaterial' || icon =='default'"></cat-constructionmaterial>
        <cat-electricalequipment v-if="icon == 'cat-electricalequipment' || icon =='default'"></cat-electricalequipment>
        <cat-constructionservices v-if="icon == 'cat-constructionservices' || icon =='default'"></cat-constructionservices>
        <cat-rawmaterials v-if="icon == 'cat-rawmaterials' || icon =='default'"></cat-rawmaterials>
        <cat-packaging v-if="icon == 'cat-packaging' || icon =='default'"></cat-packaging>
        <cat-industrialequipment v-if="icon == 'cat-industrialequipment' || icon =='default'"></cat-industrialequipment>
        <cat-industrialchemical v-if="icon == 'cat-industrialchemical' || icon =='default'"></cat-industrialchemical>
        <cat-provisionservices v-if="icon == 'cat-provisionservices' || icon =='default'"></cat-provisionservices>
        <cat-businessservices v-if="icon == 'cat-businessservices' || icon =='default'"></cat-businessservices>
        <cat-jevelrywatches v-if="icon == 'cat-jevelrywatches' || icon =='default'"></cat-jevelrywatches>
        <cat-goodscreativity v-if="icon == 'cat-goodscreativity' || icon =='default'"></cat-goodscreativity>
        <cat-souvenirsgifts v-if="icon == 'cat-souvenirsgifts' || icon =='default'"></cat-souvenirsgifts>
        <cat-other v-if="icon == 'cat-other' || icon =='default'"></cat-other>
    </div>
</template>
<script>
    export default {
        props: ["icon"],
        data() {
            return {};
        }
    };
</script>
