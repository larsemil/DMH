<?php

global $root;

include_once $root . '/classes/environment.php';
include_once $root . '/includes/navigation_control.php';

include_once $root . '/includes/swish.php';
include_once $root . '/includes/berghem_mailer.php';
include_once $root . '/includes/helper_functions.php';
include_once $root . '/includes/html_helpers.php'; 
include_once $root . '/includes/sverok.php';
include_once $root . '/includes/our_fonts.php';
include_once $root . '/includes/selection_data_control.php';


include_once $root . '/classes/dbh.php';
include_once $root . '/classes/access_control.php';

include_once $root . '/models/base_model.php';
include_once $root . '/models/selection_data.php';
include_once $root . '/models/selection_data_general.php';

include_once $root . '/models/ability.php';
include_once $root . '/models/advertisment.php';
include_once $root . '/models/advertisment_type.php';
include_once $root . '/models/alchemy_alchemist.php';
include_once $root . '/models/alchemy_essence.php';
include_once $root . '/models/alchemy_ingredient.php';
include_once $root . '/models/alchemy_recipe.php';
include_once $root . '/models/alchemy_supplier.php';
include_once $root . '/models/alchemy_supplier_ingredient.php';
include_once $root . '/models/belief.php';
include_once $root . '/models/bookkeeping.php';
include_once $root . '/models/bookkeeping_account.php';
include_once $root . '/models/budget.php';
include_once $root . '/models/campaign.php';
include_once $root . '/models/selection_data.php';
include_once $root . '/models/email.php';
include_once $root . '/models/email_to_create.php';
include_once $root . '/models/attachment.php';
include_once $root . '/models/evaluation.php';
include_once $root . '/models/experience.php';
include_once $root . '/models/group.php';
include_once $root . '/models/group_approved_copy.php';
include_once $root . '/models/grouptype.php';
include_once $root . '/models/house.php';
include_once $root . '/models/housecaretaker.php';
include_once $root . '/models/housing.php';
include_once $root . '/models/housing_request.php';
include_once $root . '/models/image.php';
include_once $root . '/models/invoice.php';
include_once $root . '/models/intrigue.php';
include_once $root . '/models/intrigue_actor.php';
include_once $root . '/models/intrigueactor_checkinletter.php';
include_once $root . '/models/intrigueactor_checkintelegram.php';
include_once $root . '/models/intrigueactor_checkinprop.php';
include_once $root . '/models/intrigueactor_knownpdf.php';
include_once $root . '/models/intrigueactor_knownprop.php';
include_once $root . '/models/intrigueactor_knownnpc.php';
include_once $root . '/models/intrigueactor_knownnpcgroup.php';
include_once $root . '/models/intrigueactor_knownactor.php';
include_once $root . '/models/intrigue_pdf.php';
include_once $root . '/models/intrigue_prop.php';
include_once $root . '/models/intrigue_npc.php';
include_once $root . '/models/intrigue_npcgroup.php';
include_once $root . '/models/intrigue_letter.php';
include_once $root . '/models/intrigue_telegram.php';
include_once $root . '/models/intrigue_type.php';
include_once $root . '/models/intrigue_vision.php';
include_once $root . '/models/larp_group.php';
include_once $root . '/models/larp_role.php';
include_once $root . '/models/larper_type.php';
include_once $root . '/models/letter.php';
include_once $root . '/models/magic_magician.php';
include_once $root . '/models/magic_school.php';
include_once $root . '/models/magic_spell.php';
include_once $root . '/models/NPC.php';
include_once $root . '/models/NPCGroup.php';
include_once $root . '/models/normal_allergy_type.php';
include_once $root . '/models/official_type.php';
include_once $root . '/models/payment_information.php';
include_once $root . '/models/person.php';
include_once $root . '/models/place_of_residence.php';
include_once $root . '/models/prop.php';
include_once $root . '/models/race.php';
include_once $root . '/models/registration.php';
include_once $root . '/models/religion.php';
include_once $root . '/models/reserve_registration.php';
include_once $root . '/models/reserve_larp_role.php';
include_once $root . '/models/resource.php';
include_once $root . '/models/resource_titledeed.php';
include_once $root . '/models/role.php';
include_once $root . '/models/role_approved_copy.php';
include_once $root . '/models/rolefunction.php';
include_once $root . '/models/rumour.php';
include_once $root . '/models/rumour_concerns.php';
include_once $root . '/models/rumour_knows.php';
include_once $root . '/models/shiptype.php';
include_once $root . '/models/subdivision.php';
include_once $root . '/models/telegram.php';
include_once $root . '/models/timeline.php';
include_once $root . '/models/titledeed.php';
include_once $root . '/models/titledeedplace.php';
include_once $root . '/models/titledeedresult.php';
include_once $root . '/models/titledeedresult_upgrade.php';
include_once $root . '/models/type_of_food.php';
include_once $root . '/models/user.php';
include_once $root . '/models/vision.php';
include_once $root . '/models/wealth.php';

include_once $root . '/models/LARP.php';
