function validate_passwd(object1, object2) {
	result=(object1.value==object2.value);
	if(!result) alert("Les mots de passes sont différents !");
}

function old_validate_passwd(thisObject, comparedToThis, buttonToEnable) {
	buttonToEnable.disabled=!(thisObject.value==comparedToThis.value);
}

function validate_member() {
	var mbr_nom=eval(document.membersForm.mbr_nom);
	var mbr_prenom=eval(document.membersForm.mbr_prenom);
	var mbr_adr1=eval(document.membersForm.mbr_adr1);
	var cp_index=eval(document.membersForm.cp_index);
	var mbr_ville=eval(document.membersForm.mbr_ville);
	var mbr_ident=eval(document.membersForm.mbr_ident);
	var mbr_mpasse=eval(document.membersForm.mbr_mpasse);
	var mbr_confirm=eval(document.membersForm.mbr_confirm);

	var msg;	

	if(mbr_nom.value=="") {
		msg+="- nom,\n";
	}

	if(mbr_prenom.value=="") {
		msg+="- prenom,\n";
	}

	if(mbr_adr1.value=="") {
		msg+="- adresse,\n";
	}

	if(mbr_ville.value=="") {
		msg+="- ville,\n";
	}

	if(cp_index.value=="") {
		msg+="- code postal,\n";
	}

	if(mbr_ident.value=="") {
		msg+="- identifiant,\n";
	}

	if(mbr_mpasse.value=="") {
		msg+="- mot de passe,\n";
	}

	if(mbr_confirm.value=="") {
		msg+="- confirmation du mot de passe,\n";
	}

	if(msg!="") {
		msg=substr(msg, 0, msg.length-3);
		msg_alert="Vous n'avez pas rempli les champs :\n"+msg;
		alert(msg_alert);

		return false;
	}

	return true;
}
