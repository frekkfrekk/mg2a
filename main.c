#include <stdio.h>
#include <stdlib.h>
int main(){
float ch,s,a;
int h,m;
unsigned n;
    printf("faites votre choix: avenir(1), impot(2)");
    scanf("%f",&ch);
    if (ch==1){
    printf("enter hour");
    scanf("%d",&h);
    printf("enter minute");
    scanf("%d",&m);
    m=m+1;
    if (m==60){
 h=h+1;
 m=00;}
 if (h==24)
 {h=00;}
 printf("dans une minute, il sera: %d heure %d minute", h,m);}
 if (ch==2){
    printf("entrer votre nom");
    scanf("%f",&n);
    printf("etes -vous de quel sexe?: masculin(1) ou feminin(2)");
    scanf("%d",&s);
    if (s=1){
        printf("quel age avez-vous?");
        scanf("%f",&a);
        if (a<19) or (a>46)
            printf("désolé monsieur, vous n'etes pas en âge de payer l_impot");
        if (a>=20) and (a<=40)
            printf("félicitation monsieur, vous etes en âge de payer l_impot");}
     }
    getchar();
    return 0;
}
