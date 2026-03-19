    $(document).ready(function(){
        $("#btn_add").click(function(){
            ajouter_une_ligne();
        });
    });

    var cont = 0; 
    var total = 0;
    $("#savebtn").hide();

    function ajouter_une_ligne2()
    {
        var idproduit = $("#article").val();
        var produit = $("#article option:selected").text();
        var quantite =  Number($("#pquantite").val());
        var stock =  Number($("#pstock").val());
        var montant_init = Number($("#pmontant").val());
        var montant_negocie = Number($("#pchmontant").val());
        var remise = Number($("#remise").val());

        // Initialize an empty array to store the items
        let articleArray = [];

        /* Nouvelle configuration */
        if(idproduit != "")
        {
            if (montant_negocie=="" || montant_negocie==0) {

                if (quantite=="" || quantite==0 || quantite<0) {
                    Swal.fire(
                        'Erreurs dans la saisie !',
                        'La quantité ne doit pas etre vide ou negative',
                        'error'
                    )
                    
                    /* Toast.fire({
                        icon: 'warning',
                        title: 'La quantité ne doit pas etre vide ou negative'
                    }); */
                }
                else {
                    if(quantite>stock){
                        Swal.fire(
                            'Erreurs dans la saisie !',
                            'La quantité ne doit pas etre superieure au STOCK',
                            'error'
                        )
                        
                        /* Toast.fire({
                            icon: 'warning',
                            title: 'La quantité ne doit pas etre superieure au STOCK'
                        }); */
                    } else {
                        montant = montant_init;

                        subtotal[cont] = (montant*quantite);
                        total=total+subtotal[cont];
                        var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant+'</td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="'+quantite+'" />'+quantite+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
                        cont++;
                        initialiser();
                        $("#total").html("Total/. "+total);
                        evaluer();
                        $("#details").append(nouvelle_ligne);
                        $("#sous_total").val(total);
                        $("#a_payer").val(total);

                        /* if ($.inArray(nouvelle_ligne, articleArray)===-1) {
                            articleArray.push(nouvelle_ligne);

                            
                        } else {
                            Swal.fire(
                                'Attention !',
                                "L'article déjà ajouté, manipulez le stock",
                                'warning'
                            )
                        } */
                        
                    }
                }
            } else {
                if (montant_negocie < montant_init) {
                    Swal.fire(
                        'Erreurs dans la saisie !',
                        'Le montant SAISI doit être superieur ou egal au montant minimum',
                        'error'
                    )
                    
                    /* Toast.fire({
                        icon: 'warning',
                        title: 'Le montant SAISI doit être superieur ou egal au montant minimum'
                    }); */
                } else {
                    if (quantite=="" || quantite==0 || quantite<0) {
                        Swal.fire(
                            'Erreurs dans la saisie !',
                            'La quantité ne doit pas etre vide ou negative',
                            'error'
                        )
                    
                        /* Toast.fire({
                            icon: 'warning',
                            title: 'La quantité ne doit pas etre vide ou negative'
                        }); */
                    }
                    else {
                        if(quantite>stock){
                            Swal.fire(
                                'Erreurs dans la saisie !',
                                'La quantité ne doit pas etre superieure au STOCK',
                                'error'
                            )
                            /* Toast.fire({
                                icon: 'warning',
                                title: 'La quantité ne doit pas etre superieure au STOCK'
                            }); */
                        } else {
                            
                            montant = montant_negocie;

                            subtotal[cont] = (montant*quantite);
                            total=total+subtotal[cont];

                            var nouvelle_ligne = '<tr class="selected" id="nouvelle_ligne'+cont+'"><td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne('+cont+');"><span class="fas fa-trash-alt" aria-hidden="true"></span></button></td> <td><input type="hidden" name="id_produit[]" value="'+idproduit+'">'+produit+' </td> <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant+'</td> <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="'+quantite+'" />'+quantite+'</td> <td class="text-center">'+subtotal[cont]+'</td> </tr>';
                            cont++;
                            initialiser();
                            $("#total").html("Total/. "+total);
                            evaluer();
                            $("#details").append(nouvelle_ligne);
                            $("#sous_total").val(total);
                            $("#a_payer").val(total);
                        }
                    }
                }
            }
        }
        else
        {
            Swal.fire(
                'Attention !',
                'Choisissez un article',
                'warning'
            )
            /* Toast.fire({
                icon: 'warning',
                title: 'Choisissez un article'
            }); */
        }
        /* Nouvelle configuration */

    }

    function ajouter_une_ligne() {
        var idproduit = $("#article").val();
        var produit = $("#article option:selected").text();
        var quantite = parseInt($("#pquantite").val()) || 0;
        var stock = parseInt($("#pstock").val()) || 0;
        var montant_init = parseFloat($("#pmontant").val()) || 0;
        var montant_negocie = parseFloat($("#pchmontant").val()) || 0;

        if (idproduit != "") {
            var ligneExistante = $("#details tbody tr").filter(function() {
                return $(this).find("input[name='id_produit[]']").val() == idproduit;
            });

            var montant = (montant_negocie > 0) ? montant_negocie : montant_init;

            if (ligneExistante.length > 0) {
                // 🔄 Fusionner les quantités
                var ancienneQuantite = parseInt(ligneExistante.find("input[name='quantite[]']").val()) || 0;
                var nouvelleQuantite = ancienneQuantite + quantite;

                if (nouvelleQuantite > stock) {
                    Swal.fire('Erreur !','La quantité totale dépasse le stock','error');
                    return;
                }

                // ✅ Mettre à jour la quantité et le montant
                ligneExistante.find("input[name='quantite[]']").val(nouvelleQuantite);
                ligneExistante.find("td:eq(3)").html('<input type="hidden" class="form-control" name="quantite[]" value="'+nouvelleQuantite+'" />'+nouvelleQuantite);

                ligneExistante.find("input[name='montant[]']").val(montant);
                ligneExistante.find("td:eq(2)").html('<input type="hidden" class="form-control" name="montant[]" value="'+montant+'" />'+montant);

                // ✅ Recalculer le sous-total
                var nouveauSousTotal = montant * nouvelleQuantite;
                ligneExistante.find("td:eq(4)").text(nouveauSousTotal);

                // 🔄 Recalculer le total global
                recalculerTotal();

                // ✨ Highlight visuel
                ligneExistante.addClass("highlight");
                setTimeout(function(){ ligneExistante.removeClass("highlight"); }, 1000);
                // 🔊 Son spécifique pour mise à jour 
                playSound("pop");

                Swal.fire({ 
                    icon: 'info', 
                    title: "Quantité mise à jour pour l'article : " + produit, 
                    toast: true, 
                    position: 'top-end', 
                    timer: 3000 
                });
            } else {
                // ➕ Nouvelle ligne
                var sousTotal = montant * quantite;

                var nouvelle_ligne = $(`
                    <tr class="selected" id="nouvelle_ligne${cont}" style="display:none;">
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="supprimer_ligne(${cont});">
                                <span class="fas fa-trash-alt" aria-hidden="true"></span>
                            </button>
                        </td>
                        <td><input type="hidden" name="id_produit[]" value="${idproduit}">${produit}</td>
                        <td class="text-center"><input type="hidden" class="form-control" name="montant[]" value="${montant}" />${montant}</td>
                        <td class="text-center"><input type="hidden" class="form-control" name="quantite[]" value="${quantite}" />${quantite}</td>
                        <td class="text-center">${sousTotal}</td>
                    </tr>
                `);

                cont++;
                initialiser();
                $("#details tbody").append(nouvelle_ligne);

                // 🔄 recalculer le total global
                recalculerTotal();

                // ✨ Highlight visuel
                nouvelle_ligne.fadeIn(500).addClass("highlight");
                setTimeout(function(){ nouvelle_ligne.removeClass("highlight"); }, 1000);
                
                // 🔊 Son spécifique pour ajout
                playSound("ding");
                
                Swal.fire({ 
                    icon: 'success', 
                    title: "Nouvel article ajouté : " + produit, 
                    toast: true, 
                    position: 'top-end', 
                    timer: 3000 
                });
            }
        } else {
            Swal.fire('Attention !','Choisissez un article','warning');
        }
    }

    function recalculerTotal() {
        total = 0;
        $("#details tbody tr").each(function() {
            var montant = parseFloat($(this).find("input[name='montant[]']").val()) || 0;
            var quantite = parseInt($(this).find("input[name='quantite[]']").val()) || 0;
            var sousTotal = montant * quantite;

            // ✅ Mettre à jour la cellule sous-total
            $(this).find("td:eq(4)").text(sousTotal);

            // ✅ Ajouter au total global
            total += sousTotal;
        });

        // ✅ Mise à jour avec animation sur le total global
        $("#total")
            .hide() // on cache 
            .html("Total/. " + total) // on met à jour 
            .fadeIn(400) // effet fade-in
            .addClass("pulse-total");
        setTimeout(function(){ $("#total").removeClass("pulse-total"); }, 600);

        $("#sous_total").val(total);
        $("#a_payer").val(total);
        evaluer();
    }

    function supprimer_ligne(index) {
        var ligne = $("#nouvelle_ligne" + index);
        // ✨ Highlight suppression
        ligne.addClass("highlight-delete").fadeOut(500, function(){
            $(this).remove();
            recalculerTotal();
        }); 
        // setTimeout(function(){ ligne.remove(); recalculerTotal(); }, 500);

        $("#remise").val("");
        $("#encaissement").val(0);
        $("#restant").val(0);

        $("#total_def").html(total);
        $("#total_def_val").val(total);

        // 🔊 Son spécifique pour suppression
        playSound("cash");
                
    }
    
    // 🎶 Fonction pour jouer différents sons 
    function playSound(type) { 
        let url; 
        switch(type) { 
            case "ding": 
                url = "https://actions.google.com/sounds/v1/alarms/beep_short.ogg"; 
                break; 
            case "pop": 
                url = "https://actions.google.com/sounds/v1/cartoon/pop.ogg"; 
                break; 
            case "cash": 
                url = "https://actions.google.com/sounds/v1/cartoon/wood_plank_flicks.ogg"; 
                break; 
            default: 
                url = "https://actions.google.com/sounds/v1/foley/cash_register.ogg"; 
        } 

        var audio = new Audio(url); 
        audio.volume = 0.9; // volume faible 
        audio.play(); 
    }

    function initialiser() {
        $('#pidproduit').val("").trigger('change');
        $("#pmontant").val(0);
        $("#pchmontant").val(0);
        $("#pquantite").val(0);
        $("#pstock").val(0);
        $("#remise").val('');
    }

    function evaluer() {
        if(total > 0) {
            $("#savebtn").show().addClass("btn-bounce");
            setTimeout(function(){ $("#savebtn").removeClass("btn-bounce"); }, 800);
        } else {
            $("#savebtn").hide();
        }
    }


    function supprimer_ligne2(index)
    {
        total = total-subtotal[index];
        $("#total").html("S/. "+total);
        $("#nouvelle_ligne" + index).remove();
        evaluer();
        $("#sous_total").val(total);

        remise = 0;
        $("#remise").val("");
        $("#encaissement").val(0);
        $("#restant").val(0);

        $("#total_def").html(total-(total*(remise/100)));
        $("#total_def_val").val(total-(total*(remise/100)));
    }