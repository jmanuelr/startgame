6	NULL	NULL	P	Número de empregados sem Ensino Fundamental	Número total de empregados sem Ensino Fundamental completo no final de 2016.		{MAX:100}=([6]/([16]+[15]-[12])*100);
↵{MIN:0}=([6]);	O número de empregados informado é maior que o número total de empregados no final do ano.	pessoas		1	N	0	N	A
7	NULL	NULL	P	Número de empregados com Ensino Fundamental	Número total de empregados com Ensino Fundamental completo no final de 2016.		{MAX:100}=([7]/([16]+[15]-[12])*100);
↵{MIN:0}=([7]);	O número de empregados informado é maior que o número total de empregados no final do ano.	pessoas		1	N	0	N	A
8	NULL	NULL	P	Tempo de treinamento	Anote o tempo total de treinamento de todos os empregados (dentro e fora do expediente) em 2016. Observe que a unidade é "horas".		{MAX:5}=([8]/[2]*100);
↵{MIN:0}=([8]);	Valores superiores a 5% do total de horas normais trabalhadas são incomuns. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	horas		1	N	0	N	A
9	NULL	NULL	P	Número de empregados com Ensino Médio	Número total de empregados com Ensino Médio completo no final de 2016. Empregados com curso técnico, ainda que pós-médio, devem ser contados como "Ensino Médio".		{MAX:100}=([9]/([16]+[15]-[12])*100);
↵{MIN:0}=([9]);	O número de empregados informado é maior que o número total de empregados no final do ano.	pessoas		1	N	0	N	A
10	NULL	NULL	P	Número de empregados com Ensino Superior	Número total de empregados com Ensino Superior completo no final de 2016.		{MAX:100}=([10]/([16]+[15]-[12])*100);
↵{MIN:0}=([10]);	O número de empregados informado é maior que o número total de empregados no final do ano.	pessoas		1	N	0	N	A
11	NULL	NULL	P	Número de empregados com Pós Graduação	Número total de empregados com Pós-Graduação completa no final de 2016.		{MAX:100}=([11]/([16]+[15]-[12])*100);
↵{MIN:0}=([11]);	O número de empregados informado é maior que o número total de empregados no final do ano.	pessoas		1	N	0	N	A
13	NULL	NULL	P	Empregados desligados em até 90 dias após a admissão	Número total de empregados desligados em 2016, tanto por iniciativa da organização como por iniciativa dos empregados, até 90 dias da data da admissão.		{MAX:30}=([13]/[16]*100);
↵{MIN:0}=([13]);	O número de desligados em até 90 dias é incomum. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	pessoas		1	N	0	N	A
14	NULL	NULL	P	Empregados que pediram demissão em 2016	Número total de empregados que pediram demissão em 2016.		{MAX:30}=([14]/[16]*100);
↵{MIN:0}=([14]);	O número de empregados que pediu demissão é muito elevado. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	pessoas		1	N	0	N	A
18	NULL	NULL	P	Número de mulheres no final de 2016	Número total de mulheres, no final de 2016.		{MAX:100}=([18]/([16]+[15]-[12])*100);
↵{MIN:0}=([18]);	O número de mulheres é maior que o número total de empregados. Por favor, verifique.	pessoas		1	N	0	N	A
19	NULL	NULL	P	Número de terceirizados no final de 2016	Número de empregados vinculados às empresas prestadoras de serviço para a execução de atividades de caráter permanente nas instalações da organização, no final de 2016. Não inclua pessoal de contratos eventuais, como reformas de escritórios, etc.		{MAX:50}=([19]/([16]+[15]-[12])*100);
↵{MIN:0}=([19]);	O número de terceirizados é muito elevado. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	pessoas		1	N	0	N	A
20	NULL	NULL	P	Número de empregados com remuneração variável	Número total de empregados existente em dezembro que recebeu algum tipo de remuneração variável em 2016. Exemplos de remuneração variável: participação nos lucros, bônus, premiação por vendas, comissões, prêmios, de reconhecimento e outras associadas ao desempenho da organização, da unidade ou individual.		{MAX:100}=([20]/([16]+[15]-[12])*100);
↵{MIN:0}=([20]);	O número de empregados com remuneração variável é maior que o número de empregados no final do ano. Por favor, verifique.	pessoas		1	N	0	N	A
21	NULL	NULL	P	Ausências por doenças ou acidentes	Anote o total de horas de trabalho perdido por afastamentos médicos, causados por doenças ocupacionais ou não, e por acidentes do trabalho, em 2016. Observe que a unidade é "horas". Nota: Nos afastamentos longos, inclusive licença maternidade, inclua apenas os primeiros 15 dias; os demais são cobertos pelo auxílio-doença, nos termos da lei 8.213.		{MAX:5}=([21]/[2]*100);
↵{MIN:0}=([21]);	Valores superiores a 5% do total de horas normais trabalhadas são incomuns. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	horas		1	N	0	N	A
22	NULL	NULL	P	Número de acidentados com afastamento em 2016	Número de empregados acidentados com afastamento, ainda que de apenas 1 dia, em 2016. Não inclua os terceirizados, estagiários e aprendizes que não fazem parte do efetivo da empresa. Observe que a unidade é "número de acidentados".		{MAX:10}=([22]/([16]+[15]-[12])*100);
↵{MIN:0}=([22]);	O número de acidentados é muito elevado. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	pessoas		1	N	0	N	A
23	NULL	NULL	P	Outras Ausências	Anote o quantidade de horas perdidas por ausências (faltas, atrasos, saídas antecipadas, justificadas ou não) do total dos empregados em 2016. Observe que a unidade é "horas".
↵Notas: Não incluir as horas perdidas por motivos médicos, como doenças e acidentes.
↵Ignorar tempos compensados via Banco de Horas. 		{MAX:5}=([23]/[2]*100);
↵{MIN:0}=([23]);	Valores superiores a 5% do total de horas normais trabalhadas são incomuns. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	horas		1	N	0	N	A
27	NULL	NULL	P	Tempo Total Perdido com Ausências (Calculado)	Compreende os tempos perdidos por ausências em 2016, incluídas as de natureza médica ou acidentária. Caso o número não corresponda a realidade, corrija as "Ausências por doenças ou acidentes" ou as "Outras ausências" informadas acima.		{CALC}=([21]+[23]);
↵{MAX:10}=([27]/[2]*100);
↵{MIN:0}=([27]);	Valores superiores a 10% do total de horas normais trabalhadas são incomuns. Por favor, verifique. Mas, se estiver correto, ignore este alerta.	horas		5	N	0	N	A