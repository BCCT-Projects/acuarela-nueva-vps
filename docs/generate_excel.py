import pandas as pd
import re
import os

# Input file path
input_file = r'f:\Codigos\BCCT\Proyecto-acuarela\acuarela-nueva-vps\docs\ESTADO_CUMPLIMIENTO_SOC2_ISO.md'
output_file = r'f:\Codigos\BCCT\Proyecto-acuarela\acuarela-nueva-vps\docs\ESTADO_CUMPLIMIENTO_SOC2_ISO.xlsx'

def parse_markdown_table(table_lines):
    # Extract headers
    headers = [h.strip() for h in table_lines[0].strip().split('|') if h.strip()]
    
    data = []
    # Skip separator line (line index 1)
    for line in table_lines[2:]:
        if not line.strip(): continue
        row = [cell.strip().replace('**', '').replace('`', '') for cell in line.strip().split('|')]
        # Drop empty first/last elements from split if pipe is at start/end
        if line.strip().startswith('|'): row = row[1:]
        if line.strip().endswith('|'): row = row[:-1]
        
        # Ensure row length matches headers
        if len(row) < len(headers):
            row += [''] * (len(headers) - len(row))
        elif len(row) > len(headers):
             row = row[:len(headers)]
             
        data.append(row)
        
    return pd.DataFrame(data, columns=headers)

with open(input_file, 'r', encoding='utf-8') as f:
    content = f.read()

# --- PART 1: INTRO ---
intro_match = re.search(r'# (.*?)\n+(.*?)\n+---', content, re.DOTALL)
intro_data = {}
intro_text = ""
if intro_match:
    title = intro_match.group(1).strip()
    intro_body = intro_match.group(2).strip()
    
    # Parse Metadata
    for line in intro_body.split('\n'):
        if ':' in line:
            key, val = line.split(':', 1)
            intro_data[key.replace('*', '').strip()] = val.replace('*', '').strip()
        elif line.strip():
            intro_text += line.strip() + "\n"
else:
    title = "Estado de Cumplimiento"

# --- PART 2: IMPROVEMENT PLAN ---
plan_match = re.search(r'## 🚀 PLAN DE MEJORA Y ESTADO ACTUAL\n+(.*)', content, re.DOTALL)
plan_text = plan_match.group(1).strip() if plan_match else ""

# --- PART 3: DOMAINS ---
# Split by "### " which denotes domains in this file
sections = re.split(r'\n### ', content)
domains = []

for section in sections:
    # Check if it looks like a domain section
    if 'DOMINIO' in section:
        lines = section.split('\n')
        
        # Title
        domain_title_raw = lines[0].strip()
        # Clean emoji and "DOMINIO X – " for sheet name
        sheet_name_match = re.search(r'DOMINIO (\d+)', domain_title_raw)
        sheet_name = f"DOMINIO {sheet_name_match.group(1)}" if sheet_name_match else domain_title_raw[:30]
        
        # Context
        context_lines = []
        table_lines = []
        in_table = False
        
        for line in lines[1:]:
            if line.strip().startswith('|'):
                in_table = True
                table_lines.append(line)
            elif in_table and not line.strip():
                in_table = False # End of table
            elif not in_table:
                # Remove "Contexto y Estrategia:" label if present to just get text
                clean_line = line.replace('**Contexto y Estrategia:**', '').strip()
                if clean_line:
                    context_lines.append(clean_line)
        
        context_text = "\n".join(context_lines)
        
        df_table = pd.DataFrame()
        if table_lines:
            df_table = parse_markdown_table(table_lines)
            
        domains.append({
            'title': domain_title_raw,
            'sheet': sheet_name,
            'context': context_text,
            'table': df_table
        })

# --- WRITE TO EXCEL ---
with pd.ExcelWriter(output_file, engine='openpyxl') as writer:
    # 1. Summary Sheet
    summary_rows = [[title]]
    for k, v in intro_data.items():
        summary_rows.append([k, v])
    summary_rows.append([])
    summary_rows.append(["Descripción General", intro_text])
    summary_rows.append([])
    summary_rows.append(["PLAN DE MEJORA Y ESTADO ACTUAL"])
    summary_rows.append([plan_text])
    
    df_summary = pd.DataFrame(summary_rows)
    df_summary.to_excel(writer, sheet_name='RESUMEN', index=False, header=False)
    
    # 2. Domain Sheets
    for d in domains:
        # Write Context first
        start_row = 0
        pd.DataFrame([d['title']]).to_excel(writer, sheet_name=d['sheet'], index=False, header=False, startrow=start_row)
        start_row += 2
        
        pd.DataFrame(["Contexto y Estrategia:", d['context']]).to_excel(writer, sheet_name=d['sheet'], index=False, header=False, startrow=start_row)
        start_row += 4
        
        # Write Table
        if not d['table'].empty:
            d['table'].to_excel(writer, sheet_name=d['sheet'], index=False, startrow=start_row)
            
        # Adjust column widths (basic)
        worksheet = writer.sheets[d['sheet']]
        for col in worksheet.columns:
            max_length = 0
            column = col[0].column_letter # Get the column name
            for cell in col:
                try:
                    if len(str(cell.value)) > max_length:
                        max_length = len(str(cell.value))
                except:
                    pass
            adjusted_width = (max_length + 2)
            # Cap width
            if adjusted_width > 60: adjusted_width = 60
            if adjusted_width < 10: adjusted_width = 10
            worksheet.column_dimensions[column].width = adjusted_width

print(f"Excel file created at: {output_file}")
