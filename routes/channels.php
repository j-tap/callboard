<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('dialog.{id}', function ($user, $id) {
    return true;
    //return (int) $user->organizaton_id === (int) $id;
});

Broadcast::channel('user.{id}', function ($user, $id) {
    //return true;
    return (int) $user->unique_id === (int) $id;
});

// Broadcast::channel('dialog.organization.{id}', function ($user, $id) {
//     return true;
//     //return (int) $user->organizaton_id === (int) $id;
// });

// нам нужно проверить, что пользователь, пытающийся слышать на приватном канале deals.buy.id, фактически является создателем
// Broadcast::channel('deals.buy.{id}', function ($user, $id) {
//     //return OrganizationDeal::DEAL_TYPE_BUY === OrganizationDeal::find($dealId)->type_deal;
//     // TODO: далее, нужно проверять, если вопль попадает в выбраную категорю юзера, то ему его показывать, иначе - НЕТ
//     return true;
// });

// Broadcast::channel('deals.buy.public', function ($user) {
//     //return OrganizationDeal::DEAL_TYPE_BUY === OrganizationDeal::find($dealId)->type_deal;
//     // TODO: далее, нужно проверять, если вопль попадает в выбраную категорю юзера, то ему его показывать, иначе - НЕТ
//     return true;
// });
