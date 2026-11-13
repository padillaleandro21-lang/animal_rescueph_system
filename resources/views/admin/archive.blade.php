<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Archive | IARAMS</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --orange-glow: rgba(249, 115, 22, 0.25);

            --black: #111111;
            --black-soft: #1a1a1a;

            --white: #ffffff;

            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;

            --danger: #dc2626;
            --danger-dark: #b91c1c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;

            background:
                radial-gradient(circle at top left, #fff7ed 0%, transparent 40%),
                radial-gradient(circle at bottom right, #ffedd5 0%, transparent 40%),
                #f8fafc;

            min-height: 100vh;

            color: var(--black);
        }

        a {
            text-decoration: none;
        }


        /* =====================================================
           TOP NAV BAR (Standalone)
        ====================================================== */

        .archive-topbar {
            position: sticky;
            top: 0;

            z-index: 100;

            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            border-bottom: 1px solid var(--gray-200);

            padding: 16px 0;
        }

        .archive-topbar-inner {
            max-width: 1400px;

            margin: 0 auto;

            padding: 0 32px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .archive-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .archive-brand-icon {
            width: 48px;
            height: 48px;

            border-radius: 14px;

            background: linear-gradient(135deg, var(--orange), var(--orange-dark));

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 22px;

            box-shadow: 0 8px 20px var(--orange-glow);
        }

        .archive-brand-text {
            display: flex;
            flex-direction: column;
        }

        .archive-brand-text strong {
            font-size: 17px;
            font-weight: 900;
            letter-spacing: -0.3px;
            line-height: 1.1;
        }

        .archive-brand-text span {
            margin-top: 3px;

            color: var(--gray-500);

            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }


        /* Back button */
        .archive-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 10px 18px;

            border: 1px solid var(--gray-200);
            border-radius: 11px;

            background: #ffffff;
            color: var(--gray-700);

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .archive-back-btn:hover {
            background: var(--orange-light);
            color: var(--orange-dark);
            border-color: #fed7aa;

            transform: translateX(-3px);

            box-shadow: 0 6px 16px var(--orange-glow);
        }


        /* =====================================================
           MAIN LAYOUT
        ====================================================== */

        .archive-main {
            max-width: 1400px;

            margin: 0 auto;

            padding: 40px 32px 60px;
        }


        /* =====================================================
           PAGE HEADER
        ====================================================== */

        .archive-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 32px;
        }

        .archive-header h1 {
            margin: 0;

            font-size: 38px;
            font-weight: 900;
            letter-spacing: -1.2px;

            line-height: 1.1;
        }

        .archive-header h1 span {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .archive-header p {
            margin: 10px 0 0;

            color: var(--gray-500);

            font-size: 15px;
            font-weight: 500;
        }

        .archive-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 8px 16px;

            background: var(--orange-light);
            border: 1px solid #fed7aa;
            border-radius: 999px;

            color: var(--orange-dark);

            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;

            white-space: nowrap;
        }

        .archive-header-badge i {
            font-size: 14px;

            animation: pulseDot 2s ease-in-out infinite;
        }

        @keyframes pulseDot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%      { transform: scale(1.2); opacity: 0.7; }
        }


        /* =====================================================
           STATISTICS CARDS
        ====================================================== */

        .archive-stat-grid {
            display: grid;

            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 20px;

            margin-bottom: 32px;
        }

        .archive-stat {
            position: relative;

            background: #ffffff;

            border: 1px solid var(--gray-200);
            border-radius: 18px;

            padding: 26px 28px;

            display: flex;
            align-items: center;
            gap: 20px;

            overflow: hidden;

            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);

            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .archive-stat::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;

            width: 160px;
            height: 160px;

            background: radial-gradient(circle, var(--orange-glow), transparent 65%);
            border-radius: 50%;

            pointer-events: none;

            transition: transform 0.4s ease;
        }

        .archive-stat:hover {
            transform: translateY(-4px);
            border-color: #fed7aa;

            box-shadow:
                0 16px 40px rgba(249, 115, 22, 0.12),
                0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .archive-stat:hover::before {
            transform: scale(1.3);
        }

        .archive-stat-icon {
            position: relative;

            width: 60px;
            height: 60px;

            border-radius: 16px;

            background: linear-gradient(135deg, var(--orange-light), #ffedd5);
            color: var(--orange-dark);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 26px;

            flex-shrink: 0;

            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.1);
        }

        .archive-stat h6 {
            margin: 0 0 6px;

            color: var(--gray-500);

            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        .archive-stat strong {
            display: block;

            font-size: 36px;
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1;

            color: var(--black);
        }


        /* =====================================================
           ARCHIVE CARD
        ====================================================== */

        .archive-card {
            background: #ffffff;

            border: 1px solid var(--gray-200);
            border-radius: 22px;

            overflow: hidden;

            box-shadow: 0 12px 40px rgba(15, 23, 42, 0.05);

            animation: cardFadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .archive-card-header {
            padding: 28px 32px 0;

            border-bottom: 1px solid var(--gray-100);
        }

        .archive-card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 24px;
        }

        .archive-card-title h2 {
            margin: 0;

            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.4px;
        }

        .archive-card-title p {
            margin: 6px 0 0;

            color: var(--gray-500);

            font-size: 14px;
            font-weight: 500;
        }


        /* =====================================================
           TABS
        ====================================================== */

        .archive-tabs {
            display: flex;

            gap: 4px;

            overflow-x: auto;

            scrollbar-width: none;
        }

        .archive-tabs::-webkit-scrollbar {
            display: none;
        }

        .archive-tab {
            position: relative;

            border: 0;
            background: transparent;

            padding: 16px 22px;

            color: var(--gray-500);

            font-family: inherit;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.2px;

            white-space: nowrap;

            cursor: pointer;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            transition: color 0.25s ease;
        }

        .archive-tab i {
            font-size: 15px;
        }

        .archive-tab::after {
            content: "";
            position: absolute;

            left: 12px;
            right: 12px;
            bottom: -1px;

            height: 3px;

            background: transparent;

            border-radius: 4px 4px 0 0;

            transform: scaleX(0);
            transform-origin: center;

            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                        background 0.25s ease;
        }

        .archive-tab:hover {
            color: var(--orange-dark);
        }

        .archive-tab:hover::after {
            transform: scaleX(0.6);
            background: #fed7aa;
        }

        .archive-tab.active {
            color: var(--orange-dark);
        }

        .archive-tab.active::after {
            transform: scaleX(1);
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
        }

        .tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 26px;
            height: 24px;

            padding: 0 8px;

            border-radius: 20px;

            background: var(--gray-100);
            color: var(--gray-600);

            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0;

            transition: all 0.25s ease;
        }

        .archive-tab.active .tab-count {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: #ffffff;

            box-shadow: 0 4px 10px var(--orange-glow);
        }


        /* =====================================================
           TAB CONTENT
        ====================================================== */

        .archive-tab-content {
            display: none;

            animation: tabFade 0.35s ease;
        }

        .archive-tab-content.active {
            display: block;
        }

        @keyframes tabFade {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }


        /* =====================================================
           TABLE
        ====================================================== */

        .table-container {
            width: 100%;

            overflow-x: auto;
        }

        .archive-table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1000px;
        }

        .archive-table thead th {
            padding: 18px 22px;

            background: linear-gradient(180deg, #fafafa, #f5f5f5);

            border-bottom: 2px solid #f97316;

            color: var(--gray-600);

            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;

            text-align: left;

            white-space: nowrap;
        }

        .archive-table thead th:first-child {
            padding-left: 32px;
        }

        .archive-table thead th:last-child {
            padding-right: 32px;
        }

        .archive-table tbody td {
            padding: 20px 22px;

            border-bottom: 1px solid var(--gray-100);

            vertical-align: middle;

            font-size: 14px;
            font-weight: 500;

            color: var(--gray-700);

            transition: background 0.2s ease;
        }

        .archive-table tbody td:first-child {
            padding-left: 32px;
        }

        .archive-table tbody td:last-child {
            padding-right: 32px;
        }

        .archive-table tbody tr {
            transition: background 0.25s ease;
        }

        .archive-table tbody tr:hover {
            background: linear-gradient(90deg, #fffaf5, #fff7ed);
        }

        .archive-table tbody tr:last-child td {
            border-bottom: 0;
        }


        /* =====================================================
           TABLE CELLS
        ====================================================== */

        .record-id {
            display: inline-flex;
            align-items: center;

            padding: 5px 11px;

            background: var(--gray-100);
            color: var(--gray-700);

            border-radius: 7px;

            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .record-main {
            display: flex;
            flex-direction: column;

            gap: 4px;
        }

        .record-main strong {
            font-size: 14px;
            font-weight: 700;

            color: var(--black);
        }

        .record-main span {
            color: var(--gray-500);

            font-size: 12.5px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 12px;

            border-radius: 999px;

            background: #fef2f2;
            color: var(--danger);

            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .status-badge i {
            font-size: 11px;
        }

        .archive-date {
            display: block;

            color: var(--gray-600);

            font-size: 13px;
            font-weight: 600;
        }

        .reason-text {
            max-width: 260px;

            color: var(--gray-600);

            font-size: 13px;
            font-weight: 500;

            line-height: 1.5;
        }


        /* =====================================================
           ACTION BUTTONS
        ====================================================== */

        .archive-actions {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .archive-action {
            width: 40px;
            height: 40px;

            border: 1px solid var(--gray-200);
            border-radius: 11px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            font-size: 15px;

            background: #ffffff;

            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .archive-action.delete {
            color: var(--danger);
        }

        .archive-action.delete:hover {
            background: linear-gradient(135deg, var(--danger), var(--danger-dark));
            color: #ffffff;
            border-color: var(--danger);

            transform: translateY(-2px);

            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }

        .archive-action.delete:active {
            transform: translateY(0) scale(0.96);
        }


        /* =====================================================
           EMPTY STATE
        ====================================================== */

        .empty-state {
            padding: 80px 25px !important;

            text-align: center;
        }

        .empty-state-icon {
            width: 84px;
            height: 84px;

            margin: 0 auto 18px;

            border-radius: 24px;

            background: linear-gradient(135deg, var(--orange-light), #ffedd5);
            color: var(--orange);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;

            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.12);
        }

        .empty-state h4 {
            margin: 0 0 8px;

            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .empty-state p {
            margin: 0;

            color: var(--gray-500);

            font-size: 14px;
            font-weight: 500;
        }


        /* =====================================================
           PAGINATION
        ====================================================== */

        .archive-pagination {
            padding: 24px 32px;

            border-top: 1px solid var(--gray-100);

            display: flex;
            justify-content: flex-end;
        }


        /* =====================================================
           ALERT
        ====================================================== */

        .archive-alert {
            border: 0;

            border-radius: 14px;

            padding: 16px 20px;

            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 24px;

            font-size: 14px;
            font-weight: 600;

            animation: alertSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .archive-alert i {
            font-size: 20px;
        }

        @keyframes alertSlideIn {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* =====================================================
           DELETE MODAL
        ====================================================== */

        #deleteArchiveModal .modal-content {
            border: 0;
            border-radius: 20px;

            overflow: hidden;

            box-shadow:
                0 32px 90px rgba(0, 0, 0, 0.22),
                0 4px 12px rgba(0, 0, 0, 0.06);

            animation: modalSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-24px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        #deleteArchiveModal .modal-header {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-bottom: 0;

            padding: 22px 28px;
        }

        #deleteArchiveModal .modal-title {
            color: #ffffff;

            font-size: 18px;
            font-weight: 900;
            letter-spacing: 0.2px;

            display: flex;
            align-items: center;
            gap: 12px;
        }

        #deleteArchiveModal .modal-title i {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 40px;
            height: 40px;

            background: rgba(255, 255, 255, 0.2);
            border-radius: 11px;

            font-size: 20px;
        }

        #deleteArchiveModal .btn-close {
            filter: invert(1) brightness(2);
            opacity: 0.9;

            transition: transform 0.3s ease, opacity 0.25s ease;
        }

        #deleteArchiveModal .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        #deleteArchiveModal .modal-body {
            padding: 32px 28px;

            background: #ffffff;
        }

        .delete-modal-icon {
            width: 84px;
            height: 84px;

            margin: 0 auto 22px;

            border-radius: 50%;

            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: var(--danger);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;

            box-shadow: 0 12px 32px rgba(220, 38, 38, 0.2);

            animation: dangerPulse 2s ease-in-out infinite;
        }

        @keyframes dangerPulse {
            0%, 100% {
                box-shadow: 0 12px 32px rgba(220, 38, 38, 0.2);
            }
            50% {
                box-shadow: 0 12px 40px rgba(220, 38, 38, 0.4);
            }
        }

        .delete-modal-title {
            margin: 0 0 12px;

            text-align: center;

            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.4px;

            color: var(--black);
        }

        .delete-modal-text {
            margin: 0 0 8px;

            text-align: center;

            color: var(--gray-600);

            font-size: 15px;
            font-weight: 500;
            line-height: 1.6;
        }

        .delete-modal-record {
            display: inline-block;

            margin-top: 8px;
            padding: 6px 14px;

            background: var(--orange-light);
            color: var(--orange-dark);

            border-radius: 8px;

            font-size: 14px;
            font-weight: 800;
        }

        .delete-modal-warning {
            margin-top: 22px;

            padding: 14px 16px;

            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid var(--danger);
            border-radius: 10px;

            color: var(--danger-dark);

            font-size: 13.5px;
            font-weight: 700;
            line-height: 1.5;
        }

        #deleteArchiveModal .modal-footer {
            padding: 20px 28px;

            background: #fafafa;
            border-top: 1px solid var(--gray-100);

            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        #deleteArchiveModal .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 12px 24px;

            border-radius: 11px;
            border: 0;

            font-family: inherit;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.3px;

            cursor: pointer;

            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        #deleteArchiveModal .btn-secondary {
            background: #f3f4f6;
            color: var(--gray-700);

            border: 1.5px solid var(--gray-200);
        }

        #deleteArchiveModal .btn-secondary:hover {
            background: #e5e7eb;
            color: var(--black);

            transform: translateY(-2px);
        }

        #deleteArchiveModal .btn-danger {
            background: linear-gradient(135deg, var(--danger), var(--danger-dark));
            color: #ffffff;

            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        #deleteArchiveModal .btn-danger:hover {
            background: linear-gradient(135deg, var(--danger-dark), #991b1b);

            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.35);
        }

        #deleteArchiveModal .btn:active {
            transform: translateY(0) scale(0.97);
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {

            .archive-stat-grid {
                grid-template-columns: 1fr;
            }

            .archive-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .archive-header h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 600px) {

            .archive-topbar-inner,
            .archive-main {
                padding-left: 18px;
                padding-right: 18px;
            }

            .archive-brand-text strong {
                font-size: 15px;
            }

            .archive-back-btn span {
                display: none;
            }

            .archive-card-header {
                padding-left: 20px;
                padding-right: 20px;
            }

            .archive-table thead th:first-child,
            .archive-table tbody td:first-child {
                padding-left: 20px;
            }

            .archive-table thead th:last-child,
            .archive-table tbody td:last-child {
                padding-right: 20px;
            }

            .archive-pagination {
                padding: 18px 20px;
                justify-content: center;
            }

            #deleteArchiveModal .modal-footer {
                flex-direction: column-reverse;
            }

            #deleteArchiveModal .btn {
                width: 100%;
                justify-content: center;
            }
        }
        /* =========================================================
   ARCHIVE SUCCESS NOTIFICATION
========================================================= */

.archive-success-alert {
    width: 100%;
    min-height: 64px;

    display: flex;
    align-items: center;

    gap: 14px;

    margin-bottom: 24px;
    padding: 12px 16px;

    background: #ffffff;

    border: 1px solid #d1fae5;
    border-left: 5px solid #16a34a;

    border-radius: 12px;

    box-shadow:
        0 4px 15px rgba(0, 0, 0, 0.06);

    box-sizing: border-box;
}


/* =========================================================
   SUCCESS ICON
========================================================= */

.archive-success-icon {
    width: 38px;
    height: 38px;

    min-width: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #dcfce7;

    color: #16a34a;

    font-size: 19px;
}


/* =========================================================
   MESSAGE
========================================================= */

.archive-success-content {
    display: flex;
    flex-direction: column;

    gap: 2px;

    flex: 1;
}

.archive-success-content strong {
    color: #166534;

    font-size: 14px;

    font-weight: 800;
}

.archive-success-content span {
    color: #4b5563;

    font-size: 14px;

    font-weight: 500;
}


/* =========================================================
   CLOSE BUTTON
========================================================= */

.archive-alert-close {
    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;

    border-radius: 7px;

    background: transparent;

    color: #6b7280;

    font-size: 13px;

    cursor: pointer;

    transition: 0.2s ease;
}

.archive-alert-close:hover {
    background: #f3f4f6;

    color: #111827;
}

    </style>

</head>

<body>


<!-- =========================================================
     TOP NAV BAR (Standalone - No Sidebar)
========================================================= -->

<header class="archive-topbar">

    <div class="archive-topbar-inner">

        <div class="archive-brand">

            <div class="archive-brand-icon">
                <i class="bi bi-archive-fill"></i>
            </div>

            <div class="archive-brand-text">
                <strong>Archive Center</strong>
                <span>IARAMS Admin</span>
            </div>

        </div>


        <a
            href="{{ route('admin.dashboard') }}"
            class="archive-back-btn"
        >
            <i class="bi bi-arrow-left"></i>
            <span>Back to Dashboard</span>
        </a>

    </div>

</header>


<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<main class="archive-main">


    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <section class="archive-header">

        <div>

            <h1>
                Archive <span>Records</span>
            </h1>

            <p>
                Manage rejected animal reports and rejected adoption applications.
            </p>

        </div>

        <div class="archive-header-badge">
            <i class="bi bi-shield-check"></i>
            Permanent Storage
        </div>

    </section>


    <!-- =====================================================
         SUCCESS / ERROR ALERTS
    ====================================================== -->
@if(session('success'))
    <div class="archive-success-alert">
        <div class="archive-success-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <div class="archive-success-content">
            <strong>Success!</strong>
            <span>{{ session('success') }}</span>
        </div>

        <button
            type="button"
            class="archive-alert-close"
            onclick="this.parentElement.remove()"
            aria-label="Close"
        >
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
@endif

    @if(session('error'))

        <div class="alert alert-danger archive-alert">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>{{ session('error') }}</span>

        </div>

    @endif


    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <section class="archive-stat-grid">

        <div class="archive-stat">

            <div class="archive-stat-icon">
                <i class="bi bi-file-earmark-x-fill"></i>
            </div>

            <div>
                <h6>Archived Animal Reports</h6>
                <strong>{{ $reports->total() }}</strong>
            </div>

        </div>


        <div class="archive-stat">

            <div class="archive-stat-icon">
                <i class="bi bi-person-x-fill"></i>
            </div>

            <div>
                <h6>Archived Adoption Applications</h6>
                <strong>{{ $applications->total() }}</strong>
            </div>

        </div>

    </section>


    <!-- =====================================================
         ARCHIVE CARD
    ====================================================== -->

    <section class="archive-card">


        <div class="archive-card-header">

            <div class="archive-card-title">

                <div>

                    <h2>Archived Records</h2>

                    <p>Archived records remain here until permanently deleted.</p>

                </div>

            </div>


            <div class="archive-tabs" role="tablist">

                <button
                    type="button"
                    class="archive-tab active"
                    data-tab="reports"
                    role="tab"
                >

                    <i class="bi bi-file-earmark-x-fill"></i>

                    Rejected Reports

                    <span class="tab-count">
                        {{ $reports->total() }}
                    </span>

                </button>


                <button
                    type="button"
                    class="archive-tab"
                    data-tab="applications"
                    role="tab"
                >

                    <i class="bi bi-person-x-fill"></i>

                    Rejected Applications

                    <span class="tab-count">
                        {{ $applications->total() }}
                    </span>

                </button>

            </div>

        </div>


        <!-- =====================================================
             REPORTS TAB
        ====================================================== -->

        <div
            id="reports"
            class="archive-tab-content active"
        >

            <div class="table-container">

                <table class="archive-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Reporter</th>
                            <th>Animal</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Rejection Reason</th>
                            <th>Archived</th>
                            <th>Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($reports as $report)

                            <tr>

                                <td>
                                    <span class="record-id">
                                        R-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>


                                <td>
                                    <div class="record-main">
                                        <strong>
                                            {{ trim($report->first_name . ' ' . $report->last_name) }}
                                        </strong>
                                        <span>{{ $report->email ?? 'No email' }}</span>
                                    </div>
                                </td>


                                <td>
                                    <div class="record-main">
                                        <strong>{{ $report->animal_type ?? 'Unknown' }}</strong>
                                        <span>{{ $report->breed ?? 'Unknown breed' }}</span>
                                    </div>
                                </td>


                                <td>
                                    <div class="record-main">
                                        <strong>{{ $report->barangay ?? 'N/A' }}</strong>
                                        <span>
                                            {{ trim(($report->city_municipality ?? '') . ', ' . ($report->province ?? '')) }}
                                        </span>
                                    </div>
                                </td>


                                <td>
                                    <span class="status-badge">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Rejected
                                    </span>
                                </td>


                                <td>
                                    <div class="reason-text">
                                        {{ $report->rejection_reason ?? 'No reason provided.' }}
                                    </div>
                                </td>


                                <td>
                                    <span class="archive-date">
                                        {{ optional($report->archived_at)->format('M d, Y h:i A') }}
                                    </span>
                                </td>


                                <td>

                                    <div class="archive-actions">

                                        <button
                                            type="button"
                                            class="archive-action delete"
                                            title="Delete Permanently"
                                            data-action="{{ route('admin.archive.report.delete', $report->id) }}"
                                            data-record="Report R-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}"
                                            onclick="openDeleteModal(this)"
                                        >
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="empty-state">

                                    <div class="empty-state-icon">
                                        <i class="bi bi-archive"></i>
                                    </div>

                                    <h4>No Archived Animal Reports</h4>

                                    <p>
                                        Rejected animal reports moved to Archive will appear here.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($reports->hasPages())

                <div class="archive-pagination">

                    {{ $reports->appends(request()->except('reports_page'))->links() }}

                </div>

            @endif

        </div>


        <!-- =====================================================
             APPLICATIONS TAB
        ====================================================== -->

        <div
            id="applications"
            class="archive-tab-content"
        >

            <div class="table-container">

                <table class="archive-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Applicant</th>
                            <th>Animal</th>
                            <th>Animal Type</th>
                            <th>Status</th>
                            <th>Archived</th>
                            <th>Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($applications as $application)

                            <tr>

                                <td>
                                    <span class="record-id">
                                        A-{{ str_pad($application->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>


                                <td>
                                    <div class="record-main">
                                        <strong>
                                            {{ $application->user->name ?? 'Unknown Applicant' }}
                                        </strong>
                                        <span>
                                            {{ $application->user->email ?? 'No email' }}
                                        </span>
                                    </div>
                                </td>


                                <td>
                                    <div class="record-main">
                                        <strong>
                                            {{ $application->animal->name ?? 'Unknown Animal' }}
                                        </strong>
                                        <span>
                                            {{ $application->animal->breed ?? 'Unknown breed' }}
                                        </span>
                                    </div>
                                </td>


                                <td>
                                    {{ $application->animal->animal_type ?? 'N/A' }}
                                </td>


                                <td>
                                    <span class="status-badge">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Rejected
                                    </span>
                                </td>


                                <td>
                                    <span class="archive-date">
                                        {{ optional($application->archived_at)->format('M d, Y h:i A') }}
                                    </span>
                                </td>


                                <td>

                                    <div class="archive-actions">

                                        <button
                                            type="button"
                                            class="archive-action delete"
                                            title="Delete Permanently"
                                            data-action="{{ route('admin.archive.application.delete', $application->id) }}"
                                            data-record="Application A-{{ str_pad($application->id, 4, '0', STR_PAD_LEFT) }}"
                                            onclick="openDeleteModal(this)"
                                        >
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="empty-state">

                                    <div class="empty-state-icon">
                                        <i class="bi bi-archive"></i>
                                    </div>

                                    <h4>No Archived Applications</h4>

                                    <p>
                                        Rejected adoption applications moved to Archive will appear here.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($applications->hasPages())

                <div class="archive-pagination">

                    {{ $applications->appends(request()->except('applications_page'))->links() }}

                </div>

            @endif

        </div>

    </section>

</main>


<!-- =========================================================
     DELETE CONFIRMATION MODAL
========================================================= -->

<div
    class="modal fade"
    id="deleteArchiveModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Confirm Permanent Deletion
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="delete-modal-icon">
                    <i class="bi bi-trash3-fill"></i>
                </div>

                <h3 class="delete-modal-title">
                    Delete this record permanently?
                </h3>

                <p class="delete-modal-text">
                    You are about to permanently delete:
                </p>

                <div style="text-align: center;">
                    <span
                        class="delete-modal-record"
                        id="deleteRecordName"
                    >
                        —
                    </span>
                </div>

                <div class="delete-modal-warning">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    This action cannot be undone. The record will be
                    permanently removed from the archive.
                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    <i class="bi bi-x-lg"></i>
                    Cancel
                </button>

                <form
                    method="POST"
                    id="deleteArchiveForm"
                    style="margin: 0;"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        <i class="bi bi-trash3-fill"></i>
                        Delete Permanently
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       ARCHIVE TABS
    ===================================================== */

    const tabs =
        document.querySelectorAll('.archive-tab');

    const contents =
        document.querySelectorAll('.archive-tab-content');


    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            const target =
                tab.dataset.tab;


            tabs.forEach(function (item) {
                item.classList.remove('active');
            });


            contents.forEach(function (content) {
                content.classList.remove('active');
            });


            tab.classList.add('active');


            const targetContent =
                document.getElementById(target);


            if (targetContent) {
                targetContent.classList.add('active');
            }

        });

    });

});


/* =====================================================
   DELETE MODAL
==================================================== */

function openDeleteModal(button) {

    const action =
        button.getAttribute('data-action');

    const record =
        button.getAttribute('data-record');


    const form =
        document.getElementById('deleteArchiveForm');

    const recordName =
        document.getElementById('deleteRecordName');


    if (form && action) {
        form.action = action;
    }


    if (recordName) {
        recordName.textContent = record || 'this record';
    }


    const modalElement =
        document.getElementById('deleteArchiveModal');


    if (modalElement && typeof bootstrap !== 'undefined') {

        const modal =
            new bootstrap.Modal(modalElement);

        modal.show();

    }

}

</script>

</body>

</html>