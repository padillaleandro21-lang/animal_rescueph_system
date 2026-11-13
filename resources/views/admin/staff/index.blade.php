{{-- resources/views/admin/staff/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Admin User | IARAMS</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --page-bg: #f8fafc;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --white: #fff;
            --danger: #ef4444;
            --danger-dark: #dc2626;
            --danger-light: #fef2f2;
            --radius-card: 24px;
            --radius-btn: 50px;
            --radius-input: 14px;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 8px 25px -4px rgba(249, 115, 22, 0.4);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--page-bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        button, input, select {
            font-family: inherit;
        }

        /* ============ HEADER (TOPBAR) ============ */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            min-height: 80px;
            padding: 12px 36px;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text);
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.5px;
            text-decoration: none;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            font-size: 22px;
            box-shadow: var(--shadow-glow);
        }

        .brand small {
            display: block;
            color: #94a3b8;
            font-size: 10px;
            letter-spacing: 1.5px;
            font-weight: 700;
        }

        /* Centered Topbar Title */
        .topbar-title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.5px;
            white-space: nowrap;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .topbar-avatar {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--orange-light);
            color: var(--orange-dark);
            font-size: 20px;
            border: 2px solid #fff;
            box-shadow: var(--shadow-sm);
        }

        .topbar-user strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .topbar-user small {
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
        }

        /* ============ PAGE ============ */

        .page {
            width: 100%;
            max-width: 1250px;
            margin: 0 auto;
            padding: 32px 24px 40px;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color .2s, gap .2s;
        }

        .back-link:hover {
            color: var(--orange-dark);
            gap: 12px;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 25px;
        }

        .page-heading h1 {
            margin: 0 0 6px;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -.8px;
            color: #0f172a;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ============ BUTTONS ============ */

        .add-staff-trigger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 12px 24px;
            border: none;
            border-radius: var(--radius-btn);
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-glow);
        }

        .add-staff-trigger:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px -5px rgba(249, 115, 22, 0.5);
            color: white;
        }

        .add-staff-trigger[aria-expanded="true"] {
            background: #1e293b;
            box-shadow: 0 8px 20px -5px rgba(30, 41, 59, 0.4);
        }

        /* ============ NOTIFICATIONS ============ */

        .notice {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            border: 1px solid #fed7aa;
            border-radius: var(--radius-card);
            background: var(--orange-light);
            color: #9a3412;
            font-size: 13px;
            line-height: 1.65;
        }

        .notice i {
            margin-top: 2px;
            font-size: 18px;
            flex-shrink: 0;
            color: var(--orange-dark);
        }

        .notice strong {
            font-size: 13px;
            font-weight: 800;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 4px;
            border-radius: var(--radius-card);
            font-size: 13.5px;
            border: 0;
            padding: 16px 20px;
            font-weight: 600;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: var(--danger-light);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert ul {
            padding-left: 18px;
        }

        /* ============ SUMMARY CARDS ============ */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            background: white;
            box-shadow: var(--shadow-sm);
            transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow .3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: var(--orange-light);
            color: var(--orange-dark);
            font-size: 24px;
        }

        .stat-label {
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #0f172a;
        }

        /* ============ FORM ============ */

        .staff-form-card {
            overflow: hidden;
            margin-bottom: 28px;
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            background: white;
            box-shadow: var(--shadow-md);
        }

        .staff-form-heading {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 28px 32px;
            background: linear-gradient(135deg, #fff7ed, #fff);
            border-bottom: 1px solid #f1e6dc;
        }

        .staff-form-icon {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            font-size: 24px;
            box-shadow: var(--shadow-glow);
        }

        .staff-form-heading h2 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .staff-form-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .staff-form-body {
            padding: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .field {
            min-width: 0;
        }

        .staff-label {
            display: block;
            margin-bottom: 10px;
            color: #334155;
            font-size: 13.5px;
            font-weight: 700;
        }

        .staff-label .req {
            color: var(--orange-dark);
        }

        .staff-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .staff-input-wrap > .field-icon {
            position: absolute;
            left: 16px;
            z-index: 1;
            color: #94a3b8;
            font-size: 18px;
            pointer-events: none;
        }

        .staff-input {
            display: block;
            width: 100%;
            min-height: 52px;
            padding: 14px 16px 14px 48px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-input);
            background: #f8fafc;
            color: #0f172a;
            font-size: 14px;
            font-weight: 500;
            outline: none;
            transition: all .2s;
        }

        .staff-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .staff-input:focus {
            border-color: var(--orange);
            background: white;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, .15);
        }

        .staff-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16' fill='%2394a3b8'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 44px;
        }

        .staff-help {
            display: block;
            margin-top: 10px;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.6;
            font-weight: 500;
        }

        .password-input {
            padding-right: 56px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            z-index: 2;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            transform: translateY(-50%);
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #64748b;
            font-size: 18px;
            cursor: pointer;
            transition: all .2s;
        }

        .password-toggle:hover {
            background: var(--orange-light);
            color: var(--orange-dark);
        }

        .staff-form-divider {
            height: 1px;
            margin: 28px 0 24px;
            background: #f1f5f9;
        }

        .staff-form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 12px;
        }

        .staff-cancel-btn,
        .staff-submit-btn {
            min-height: 48px;
            padding: 12px 24px;
            border-radius: var(--radius-btn);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .3s;
        }

        .staff-cancel-btn {
            border: 2px solid #e2e8f0;
            background: white;
            color: #475569;
        }

        .staff-cancel-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .staff-submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            box-shadow: var(--shadow-glow);
        }

        .staff-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.5);
            color: white;
        }

        /* ============ PANEL / TABLE ============ */

        .panel {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            background: white;
            box-shadow: var(--shadow-sm);
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
        }

        .panel-heading h2 {
            margin: 0 0 6px;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.3px;
        }

        .panel-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }

        .search-box {
            position: relative;
            width: 300px;
            max-width: 100%;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .search-box input {
            width: 100%;
            min-height: 46px;
            padding: 12px 14px 12px 42px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-btn);
            background: #f8fafc;
            outline: none;
            font-size: 13px;
            font-weight: 500;
            transition: all .2s;
        }

        .search-box input:focus {
            border-color: var(--orange);
            background: white;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, .15);
        }

        .table-wrap {
            overflow-x: auto;
        }

        .staff-table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
        }

        .staff-table thead {
            background: #f8fafc;
        }

        .staff-table th {
            padding: 16px 28px;
            color: #64748b;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .8px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .staff-table th.text-end {
            text-align: right;
        }

        .staff-table td {
            padding: 20px 28px;
            border-top: 1px solid #f1f5f9;
            font-size: 13.5px;
            vertical-align: middle;
            font-weight: 500;
        }

        .staff-table tbody tr {
            transition: background .2s;
        }

        .staff-table tbody tr:hover {
            background: #fffaf6;
        }

        .account-name {
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .account-avatar {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--orange-light), #ffe4cc);
            color: var(--orange-dark);
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .5px;
            box-shadow: 0 4px 10px rgba(249, 115, 22, .15);
        }

        .account-email {
            margin-top: 5px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            overflow-wrap: anywhere;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: var(--radius-btn);
            background: #f1f5f9;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
            letter-spacing: .3px;
        }

        .role-owner    { background: #fff7ed; color: #9a3412; border: 1px solid #fed7aa; }
        .role-admin    { background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .role-rescue   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .role-shelter  { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .role-adoption { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .role-default  { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }

        .row-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            background: white;
            color: #64748b;
            font-size: 16px;
            cursor: pointer;
            transition: all .25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .icon-btn:hover {
            border-color: var(--orange);
            background: var(--orange-light);
            color: var(--orange-dark);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 15px rgba(249, 115, 22, .2);
        }

        .icon-btn.danger:hover {
            border-color: var(--danger);
            background: var(--danger-light);
            color: var(--danger);
            box-shadow: 0 6px 15px rgba(239, 68, 68, .2);
        }

        .icon-btn:disabled {
            opacity: .3;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            border-color: #e2e8f0;
            background: white;
            color: #94a3b8;
        }

        .empty-state {
            padding: 60px 20px;
            color: var(--muted);
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 16px;
            color: #cbd5e1;
            font-size: 48px;
        }

        .empty-state strong {
            display: block;
            margin-bottom: 8px;
            color: #475569;
            font-size: 16px;
            font-weight: 800;
        }

        .panel-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding: 18px 28px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            background: #f8fafc;
            font-weight: 600;
        }

        .footer {
            padding: 24px;
            color: #94a3b8;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
        }

        /* ============ MODALS ============ */

        .modal-content {
            border: 0;
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            align-items: center;
            gap: 16px;
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, #fff7ed, #fff);
        }

        .modal-header .modal-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 4px;
            color: #0f172a;
            letter-spacing: -.3px;
        }

        .modal-header .modal-sub {
            font-size: 12px;
            color: var(--muted);
            margin: 0;
            font-weight: 500;
        }

        .modal-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: var(--orange-light);
            color: var(--orange-dark);
            font-size: 22px;
        }

        .modal-icon.danger {
            background: var(--danger-light);
            color: var(--danger);
        }

        .modal-body {
            padding: 28px;
        }

        .modal-footer {
            padding: 18px 28px;
            border-top: 1px solid var(--border);
            background: #f8fafc;
            gap: 12px;
        }

        .btn-soft {
            min-height: 46px;
            padding: 12px 22px;
            border-radius: var(--radius-btn);
            border: 2px solid #e2e8f0;
            background: white;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-soft:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .btn-primary-solid,
        .btn-danger-solid {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 12px 24px;
            border-radius: var(--radius-btn);
            border: none;
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .3s;
        }

        .btn-primary-solid {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            box-shadow: var(--shadow-glow);
        }

        .btn-primary-solid:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.5);
        }

        .btn-danger-solid {
            background: linear-gradient(135deg, var(--danger), var(--danger-dark));
            box-shadow: 0 8px 25px -4px rgba(239, 68, 68, 0.4);
        }

        .btn-danger-solid:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px -5px rgba(239, 68, 68, 0.5);
        }

        .danger-box {
            display: flex;
            gap: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            border: 1px solid #fecaca;
            border-radius: var(--radius-input);
            background: var(--danger-light);
            color: #991b1b;
            font-size: 13px;
            line-height: 1.6;
            font-weight: 500;
        }

        .danger-box i {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .target-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            margin-bottom: 20px;
            border-radius: var(--radius-btn);
            background: #f1f5f9;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid #e2e8f0;
        }

        .target-chip i {
            color: var(--orange-dark);
            font-size: 16px;
        }

        .generate-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            padding: 8px 16px;
            border: 2px dashed #cbd5e1;
            border-radius: var(--radius-btn);
            background: white;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .generate-btn:hover {
            border-color: var(--orange);
            color: var(--orange-dark);
            background: var(--orange-light);
        }

        /* ============ RESPONSIVE ============ */

        @media (max-width: 900px) {
            .topbar-title {
                position: static;
                transform: none;
                font-size: 16px;
                order: 3;
                width: 100%;
                text-align: center;
                margin-top: 8px;
            }
            .topbar {
                flex-wrap: wrap;
                padding: 16px 20px;
            }
        }

        @media (max-width: 700px) {
            .page {
                padding: 24px 16px 32px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .page-heading > div,
            .add-staff-trigger {
                width: 100%;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .panel-heading {
                padding: 20px;
            }

            .search-box {
                width: 100%;
            }

            .staff-form-heading {
                padding: 24px 20px;
                align-items: flex-start;
            }

            .staff-form-heading h2 {
                font-size: 20px;
            }

            .staff-form-body {
                padding: 24px 20px;
            }

            .staff-form-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .staff-cancel-btn,
            .staff-submit-btn {
                width: 100%;
            }

            .modal-footer {
                flex-direction: column-reverse;
            }

            .modal-footer > * {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<header class="topbar">
    <!-- Left: Brand -->
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <div class="brand-icon">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <span>
            Animal Rescue PH
            <small>ADMIN PANEL</small>
        </span>
    </a>

    <!-- Center: Page Title -->
    

    <!-- Right: User Profile -->
    <div class="topbar-user">
        <div class="topbar-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <div>
            <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
            <small>{{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'admin')) }}</small>
        </div>
    </div>
</header>

<main class="page">

    <div class="page-heading">
        <div>
            <h1>Manage Admin User</h1>
            <p>Manage authorized admin user accounts and their assigned roles.</p>
        </div>

        <button
            type="button"
            class="add-staff-trigger"
            data-bs-toggle="collapse"
            data-bs-target="#addStaffForm"
            aria-expanded="{{ session('open_staff_form') || $errors->any() ? 'true' : 'false' }}"
            aria-controls="addStaffForm"
        >
            <i class="bi bi-person-plus-fill"></i>
            Add Admin User
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="notice">
        <i class="bi bi-shield-lock-fill"></i>
        <div>
            <strong>Admin account security</strong><br>
            Assign only the role needed for each admin user. Backend permissions
            must also restrict which pages and actions each role can access.
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <strong>Please check the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ================= ADD STAFF FORM ================= --}}
    <div
        class="collapse mb-4 {{ session('open_staff_form') || $errors->any() ? 'show' : '' }}"
        id="addStaffForm"
    >
        <div class="staff-form-card">
            <div class="staff-form-heading">
                <div class="staff-form-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <div>
                    <h2>Create Admin User</h2>
                    <p>Register an admin user and assign their system role.</p>
                </div>
            </div>

            <div class="staff-form-body">
                <form method="POST" action="{{ route('admin.staff.store') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label for="staffEmail" class="staff-label">
                                Email Address <span class="req">*</span>
                            </label>
                            <div class="staff-input-wrap">
                                <i class="bi bi-envelope field-icon"></i>
                                <input type="email" id="staffEmail" name="email" class="staff-input"
                                       value="{{ old('email') }}" placeholder="Enter admin email address"
                                       maxlength="255" autocomplete="email" required>
                            </div>
                        </div>

                        <div class="field">
                            <label for="staffRole" class="staff-label">
                                User Role <span class="req">*</span>
                            </label>
                            <div class="staff-input-wrap">
                                <i class="bi bi-shield-check field-icon"></i>
                                <select name="role" id="staffRole" class="staff-input staff-select" required>
                                    <option value="">Choose a user role</option>
                                    <option value="rescue_staff" @selected(old('role') === 'rescue_staff')>Rescue Staff / Approver</option>
                                    <option value="shelter_staff" @selected(old('role') === 'shelter_staff')>Shelter Staff</option>
                                    <option value="adoption_staff" @selected(old('role') === 'adoption_staff')>Adoption Staff</option>
                                </select>
                            </div>
                            <small class="staff-help">The assigned role determines which system features the admin user may access.</small>
                        </div>

                        <div class="field">
                            <label for="staffPassword" class="staff-label">
                                Password <span class="req">*</span>
                            </label>
                            <div class="staff-input-wrap">
                                <i class="bi bi-lock field-icon"></i>
                                <input type="password" id="staffPassword" name="password" class="staff-input password-input"
                                       placeholder="Create a password" minlength="8" autocomplete="new-password" required>
                                <button type="button" class="password-toggle" data-target="staffPassword"
                                        aria-label="Show password" aria-pressed="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="staff-help">Use at least 8 characters.</small>
                        </div>

                        <div class="field">
                            <label for="staffPasswordConfirmation" class="staff-label">
                                Confirm Password <span class="req">*</span>
                            </label>
                            <div class="staff-input-wrap">
                                <i class="bi bi-lock-fill field-icon"></i>
                                <input type="password" id="staffPasswordConfirmation" name="password_confirmation"
                                       class="staff-input password-input" placeholder="Re-enter the password"
                                       minlength="8" autocomplete="new-password" required>
                                <button type="button" class="password-toggle" data-target="staffPasswordConfirmation"
                                        aria-label="Show confirm password" aria-pressed="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="staff-form-divider"></div>

                    <div class="staff-form-actions">
                        <button type="button" class="staff-cancel-btn" data-bs-toggle="collapse" data-bs-target="#addStaffForm">
                            Cancel
                        </button>
                        <button type="submit" class="staff-submit-btn">
                            <i class="bi bi-person-check-fill"></i>
                            Create Admin User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= SUMMARY CARDS ================= --}}
    <section class="stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-label">Listed Accounts</div>
                <div class="stat-value">{{ $staff->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <div class="stat-label">Owner Accounts</div>
                <div class="stat-value">{{ $staff->where('role', 'owner')->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div>
                <div class="stat-label">Other Staff Accounts</div>
                <div class="stat-value">
                    {{ $staff->whereIn('role', ['admin', 'rescue_staff', 'shelter_staff', 'adoption_staff'])->count() }}
                </div>
            </div>
        </div>
    </section>

    {{-- ================= STAFF DIRECTORY ================= --}}
    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Admin User Directory</h2>
                <p>View, edit, and manage registered admin accounts.</p>
            </div>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" id="staffSearch" placeholder="Search name, email, or role..." aria-label="Search admin accounts">
            </div>
        </div>

        <div class="table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="staffTableBody">
                    @forelse ($staff as $account)
                        @php
                            $roleKey = strtolower($account->role ?? 'user');
                            $roleClass = [
                                'owner'          => 'role-owner',
                                'admin'          => 'role-admin',
                                'rescue_staff'   => 'role-rescue',
                                'shelter_staff'  => 'role-shelter',
                                'adoption_staff' => 'role-adoption',
                            ][$roleKey] ?? 'role-default';

                            $initials = collect(explode(' ', trim($account->name ?? 'User')))
                                ->filter()->take(2)
                                ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                ->implode('');

                            $isSelf = auth()->id() === $account->id;
                        @endphp
                        <tr class="staff-row">
                            <td>
                                <div class="account-name">
                                    <div class="account-avatar">{{ $initials ?: 'U' }}</div>
                                    <div>
                                        <div>{{ $account->name }}</div>
                                        <div class="account-email">{{ $account->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $account->username ?? '—' }}</td>
                            <td>
                                <span class="role-badge {{ $roleClass }}">
                                    <i class="bi bi-circle-fill" style="font-size:6px;"></i>
                                    {{ ucfirst(str_replace('_', ' ', $account->role ?? 'user')) }}
                                </span>
                            </td>
                            <td>
                                <div class="row-actions">
                                    <button type="button" class="icon-btn" title="Edit account details"
                                            data-bs-toggle="modal" data-bs-target="#editAccountModal"
                                            data-action="{{ route('admin.staff.update', $account) }}"
                                            data-name="{{ $account->name }}" data-username="{{ $account->username }}"
                                            data-email="{{ $account->email }}" data-role="{{ $account->role }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="icon-btn" title="Change password"
                                            data-bs-toggle="modal" data-bs-target="#resetPasswordModal"
                                            data-action="{{ route('admin.staff.password', $account) }}"
                                            data-name="{{ $account->name }}" data-email="{{ $account->email }}">
                                        <i class="bi bi-key-fill"></i>
                                    </button>
                                    @if ($isSelf)
                                        <button type="button" class="icon-btn danger" disabled title="You cannot delete your own account">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @else
                                        <button type="button" class="icon-btn danger" title="Delete account"
                                                data-bs-toggle="modal" data-bs-target="#deleteAccountModal"
                                                data-action="{{ route('admin.staff.destroy', $account) }}"
                                                data-name="{{ $account->name }}" data-email="{{ $account->email }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <strong>No admin accounts found</strong>
                                    No accounts match the admin roles currently configured.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchResults" style="display: none;">
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="bi bi-search"></i>
                                <strong>No matching accounts</strong>
                                Try a different search term.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel-footer">
            <span>Showing <strong id="visibleCount">{{ $staff->count() }}</strong> of {{ $staff->count() }} listed accounts.</span>
            <span><i class="bi bi-info-circle"></i> Roles control access to system features.</span>
        </div>
    </section>
</main>

<footer class="footer">
    Integrated Animal Rescue and Adoption Management System &copy; {{ date('Y') }}
</footer>


{{-- ================= EDIT ACCOUNT MODAL ================= --}}
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="" id="editAccountForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <div class="modal-icon"><i class="bi bi-pencil-square"></i></div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title" id="editAccountModalLabel">Edit Admin Account</h5>
                        <p class="modal-sub">Update account details and role assignment.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="target-chip">
                        <i class="bi bi-person-circle"></i>
                        <span id="editTargetName">—</span>
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="staff-label">Full Name <span class="req">*</span></label>
                        <div class="staff-input-wrap">
                            <i class="bi bi-person field-icon"></i>
                            <input type="text" id="editName" name="name" class="staff-input" maxlength="255" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editUsername" class="staff-label">Username</label>
                        <div class="staff-input-wrap">
                            <i class="bi bi-at field-icon"></i>
                            <input type="text" id="editUsername" name="username" class="staff-input" maxlength="255" placeholder="Optional username">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="staff-label">Email Address <span class="req">*</span></label>
                        <div class="staff-input-wrap">
                            <i class="bi bi-envelope field-icon"></i>
                            <input type="email" id="editEmail" name="email" class="staff-input" maxlength="255" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label for="editRole" class="staff-label">User Role <span class="req">*</span></label>
                        <div class="staff-input-wrap">
                            <i class="bi bi-shield-check field-icon"></i>
                            <select id="editRole" name="role" class="staff-input staff-select" required>
                                <option value="owner">Owner</option>
                                <option value="admin">Admin</option>
                                <option value="rescue_staff">Rescue Staff / Approver</option>
                                <option value="shelter_staff">Shelter Staff</option>
                                <option value="adoption_staff">Adoption Staff</option>
                            </select>
                        </div>
                        <small class="staff-help">Changing a role immediately changes what this account can access.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-solid">
                        <i class="bi bi-check2-circle"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ================= RESET PASSWORD MODAL ================= --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="" id="resetPasswordForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <div class="modal-icon"><i class="bi bi-key-fill"></i></div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Change Password</h5>
                        <p class="modal-sub">Set a new password for this account.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="target-chip">
                        <i class="bi bi-person-circle"></i>
                        <span id="passwordTargetName">—</span>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="staff-label">New Password <span class="req">*</span></label>
                        <div class="staff-input-wrap">
                            <i class="bi bi-lock field-icon"></i>
                            <input type="password" id="newPassword" name="password" class="staff-input password-input"
                                   placeholder="Enter new password" minlength="8" autocomplete="new-password" required>
                            <button type="button" class="password-toggle" data-target="newPassword"
                                    aria-label="Show password" aria-pressed="false">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <button type="button" class="generate-btn" id="generatePasswordBtn">
                            <i class="bi bi-magic"></i> Generate strong password
                        </button>
                    </div>
                    <div class="mb-0">
                        <label for="newPasswordConfirmation" class="staff-label">Confirm New Password <span class="req">*</span></label>
                        <div class="staff-input-wrap">
                            <i class="bi bi-lock-fill field-icon"></i>
                            <input type="password" id="newPasswordConfirmation" name="password_confirmation"
                                   class="staff-input password-input" placeholder="Re-enter new password"
                                   minlength="8" autocomplete="new-password" required>
                            <button type="button" class="password-toggle" data-target="newPasswordConfirmation"
                                    aria-label="Show confirm password" aria-pressed="false">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="staff-help">Use at least 8 characters. The admin user will use this password on their next sign-in.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-solid">
                        <i class="bi bi-shield-lock-fill"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ================= DELETE ACCOUNT MODAL ================= --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="" id="deleteAccountForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <div class="modal-icon danger"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Delete Admin Account</h5>
                        <p class="modal-sub">This action cannot be undone.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="danger-box">
                        <i class="bi bi-shield-exclamation"></i>
                        <div>You are about to permanently delete this admin account. The user will immediately lose access to the system.</div>
                    </div>
                    <div class="target-chip">
                        <i class="bi bi-person-x-fill"></i>
                        <span id="deleteTargetName">—</span>
                    </div>
                    <p class="mb-0" style="font-size:13.5px; color:#475569; line-height:1.7; font-weight:500;">
                        To confirm, type <strong>DELETE</strong> in the field below.
                    </p>
                    <div class="staff-input-wrap mt-3">
                        <i class="bi bi-input-cursor-text field-icon"></i>
                        <input type="text" id="deleteConfirmInput" class="staff-input" placeholder="Type DELETE to confirm" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-danger-solid" id="deleteSubmitBtn" disabled>
                        <i class="bi bi-trash3-fill"></i> Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    'use strict';

    /* ============ SEARCH DIRECTORY ============ */
    const searchInput  = document.getElementById('staffSearch');
    const staffRows    = document.querySelectorAll('.staff-row');
    const visibleCount = document.getElementById('visibleCount');
    const noResults    = document.getElementById('noSearchResults');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            let visible = 0;
            staffRows.forEach(function (row) {
                const matches = row.textContent.toLowerCase().includes(query);
                row.style.display = matches ? '' : 'none';
                if (matches) visible++;
            });
            if (visibleCount) visibleCount.textContent = visible;
            if (noResults) noResults.style.display = staffRows.length > 0 && visible === 0 ? '' : 'none';
        });
    }

    /* ============ SHOW / HIDE PASSWORDS ============ */
    document.querySelectorAll('.password-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            if (!input) return;
            const showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            this.innerHTML = showPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
            this.setAttribute('aria-label', showPassword ? 'Hide password' : 'Show password');
            this.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
        });
    });

    /* ============ EDIT ACCOUNT MODAL ============ */
    const editModal = document.getElementById('editAccountModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;
            const form = document.getElementById('editAccountForm');
            form.setAttribute('action', button.dataset.action || '');
            document.getElementById('editTargetName').textContent = button.dataset.name || 'Admin account';
            document.getElementById('editName').value     = button.dataset.name || '';
            document.getElementById('editUsername').value = button.dataset.username || '';
            document.getElementById('editEmail').value    = button.dataset.email || '';
            document.getElementById('editRole').value     = button.dataset.role || 'admin';
        });
    }

    /* ============ RESET PASSWORD MODAL ============ */
    const passwordModal = document.getElementById('resetPasswordModal');
    if (passwordModal) {
        passwordModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;
            const form = document.getElementById('resetPasswordForm');
            form.setAttribute('action', button.dataset.action || '');
            document.getElementById('passwordTargetName').textContent = button.dataset.name || 'Admin account';
            ['newPassword', 'newPasswordConfirmation'].forEach(function (id) {
                const input = document.getElementById(id);
                input.value = '';
                input.type  = 'password';
            });
            document.querySelectorAll('#resetPasswordModal .password-toggle').forEach(function (btn) {
                btn.innerHTML = '<i class="bi bi-eye"></i>';
                btn.setAttribute('aria-pressed', 'false');
            });
        });
    }

    /* ============ GENERATE PASSWORD ============ */
    const generateBtn = document.getElementById('generatePasswordBtn');
    if (generateBtn) {
        generateBtn.addEventListener('click', function () {
            const charset = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%&*';
            const length  = 12;
            const values  = new Uint32Array(length);
            (window.crypto || window.msCrypto).getRandomValues(values);
            let password = '';
            for (let i = 0; i < length; i++) password += charset[values[i] % charset.length];
            const first  = document.getElementById('newPassword');
            const second = document.getElementById('newPasswordConfirmation');
            first.value  = password;
            second.value = password;
            first.type  = 'text';
            second.type = 'text';
            document.querySelectorAll('#resetPasswordModal .password-toggle').forEach(function (btn) {
                btn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                btn.setAttribute('aria-pressed', 'true');
            });
            first.focus();
            first.select();
            if (navigator.clipboard) navigator.clipboard.writeText(password).catch(function () {});
        });
    }

    /* ============ DELETE ACCOUNT MODAL ============ */
    const deleteModal = document.getElementById('deleteAccountModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;
            const form = document.getElementById('deleteAccountForm');
            form.setAttribute('action', button.dataset.action || '');
            document.getElementById('deleteTargetName').textContent =
                (button.dataset.name || 'Admin account') + (button.dataset.email ? ' · ' + button.dataset.email : '');
            const confirmInput = document.getElementById('deleteConfirmInput');
            const submitBtn    = document.getElementById('deleteSubmitBtn');
            confirmInput.value    = '';
            submitBtn.disabled    = true;
            confirmInput.focus();
        });
    }

    const deleteConfirmInput = document.getElementById('deleteConfirmInput');
    const deleteSubmitBtn    = document.getElementById('deleteSubmitBtn');
    if (deleteConfirmInput && deleteSubmitBtn) {
        deleteConfirmInput.addEventListener('input', function () {
            deleteSubmitBtn.disabled = this.value.trim().toUpperCase() !== 'DELETE';
        });
    }

    /* ============ KEEP ADD FORM OPEN AFTER ERRORS ============ */
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('addStaffForm');
        if (form && form.classList.contains('show')) {
            const trigger = document.querySelector('[data-bs-target="#addStaffForm"]');
            if (trigger) trigger.setAttribute('aria-expanded', 'true');
        }
    });
})();
</script>

</body>
</html>