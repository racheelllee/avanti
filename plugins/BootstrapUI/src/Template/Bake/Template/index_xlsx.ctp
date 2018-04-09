<?php 
   
    $nombre_reporte="<%= $pluralVar %>_".date('Y-m-d_H_i_s');
    $this->Excel->set_header('<%= $pluralVar %>');

    $row=3;
    $col=0;

            
<% foreach ($fields as $field): %>
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('<%= $field %>'));
<% endforeach; %>

    foreach ($<%= $pluralVar %> as $<%= $singularVar %>){
        $row++;
        $col=0;
<%        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['BelongsTo'])) {
                foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
%>
                

                $valor = $<%= $singularVar %>->has('<%= $details['property'] %>') ? $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %> : '';

                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$valor);
<%
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                $valor=h($<%= $singularVar %>-><%= $field %>);
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$valor);

<%
                } else {
%>
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($<%= $singularVar %>-><%= $field %>));
<%
                }
            }
        }

        $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
        }

        $this->Excel->do_print($nombre_reporte.'.xlsx');
                
            exit;

?>